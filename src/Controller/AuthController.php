<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;
use Cake\Mailer\Mailer;
use Cake\Utility\Security;

/**
 * Auth Controller
 *
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 */
class AuthController extends AppController
{
    /**
     * @return void
     * @var \App\Model\Table\RolesTable $Roles
     * private UsersTable $Users;
     * private RolesTable $Roles;
     *
     * /**
     * Controller initialize override
     * @var \App\Model\Table\UsersTable $Users
     */
    public function initialize(): void
    {
        parent::initialize();

        // By default, CakePHP will (sensibly) default to preventing users from accessing any actions on a controller.
        // These actions, however, are typically required for users who have not yet logged in.
        $this->Authentication->allowUnauthenticated(['login', 'forgetPassword', 'resetPassword']);

        // CakePHP loads the model with the same name as the controller by default.
        // Since we don't have an Auth model, we'll need to load "Users" model when starting the controller manually.
        $this->Users = $this->fetchTable('Users');
        $this->Roles = $this->fetchTable('Roles');
    }

    /**
     * Register method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function register()
    {
        if ($this->allowEntry() === false) {
            $this->Flash->error('You do not have access to this page.');
            return $this->redirect(['action' => 'selectLocation']);
        }

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // Generate a random password
            $randomPassword = $this->generateRandomPassword();

            // Set nonce and expiry date for password reset (3 days)
            $user->nonce = Security::randomString(128);
            $user->nonce_expiry = new DateTime('+3 days');

            // Hash the random password
            $user->password = $randomPassword;

            // Save the user entity
            if ($this->Users->save($user)) {
                // Send Set Up Account email
                $mailer = new Mailer('default');
                $mailer
                    ->setFrom(['booking.no-reply@pramspa.au' => 'Pram Spa'])
                    ->setEmailFormat('html')
                    ->setTo($user->email)
                    ->setSubject('Setup Your New Pram Spa Account')
                    ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setTemplate('set_new_password');

                // Pass necessary variables to the email template
                $mailer->setViewVars([
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'nonce' => $user->nonce,
                    'email' => $user->email
                ]);

                // Check if the email was successfully delivered
                if ($mailer->deliver()) {
                    $this->Flash->success('The new staff account has been registered, please inform them to check their email to set their password.');
                } else {
                    $this->Flash->error('The new staff account was registered, but the set password email could not be sent.');
                }

                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('The new staff account could not be registered. Please check if the staff email has already been used.');
        }

        $roles = $this->Users->Roles->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
            'conditions' => ['Roles.id != ' => 4],
            'limit' => 200
        ])->toArray();
        $this->set(compact('user', 'roles'));
    }

    /**
     * Forget Password method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful email send, renders view otherwise.
     */
    public function forgetPassword()
    {
        if ($this->request->is('post')) {
            // Retrieve the user entity by provided email address
            $user = $this->Users->findByEmail($this->request->getData('email'))->first();
            if ($user) {
                // Set nonce and expiry date
                $user->nonce = Security::randomString(128);
                $user->nonce_expiry = new DateTime('+3 days');
                if ($this->Users->save($user)) {
                    // Now let's send the password reset email
                    $mailer = new Mailer('default');

                    // email basic config
                    $mailer
                        ->setFrom(['booking.no-reply@pramspa.au' => 'Pram Spa'])
                        ->setEmailFormat('html')
                        ->setTo($user->email)
                        ->setSubject('Reset your account password');

                    // select email template
                    $mailer
                        ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])->setTemplate('reset_password');

                    // transfer required view variables to email template
                    $mailer
                        ->setViewVars([
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'nonce' => $user->nonce,
                            'email' => $user->email,
                        ]);

                    //Send email
                    if (!$mailer->deliver()) {
                        // Just in case something goes wrong when sending emails
                        $this->Flash->error('We have encountered an issue when sending you an email. Please try again.');

                        return $this->render(); // Skip the rest of the controller and render the view
                    }
                } else {
                    // Just in case something goes wrong when saving nonce and expiry
                    $this->Flash->error('We are having issues with resetting your password. Please try again. ');

                    return $this->render(); // Skip the rest of the controller and render the view
                }
            }

            /*
             * **This is a bit of a special design**
             * We don't tell the user if their account exists, or if the email has been sent,
             * because it may be used by someone with malicious intent. We only need to tell
             * the user that they'll get an email.
             */
            $this->Flash->success('Please check your inbox (or spam folder) for an email regarding how to reset your account password.');
        }
    }

    /**
     * Reset Password method
     *
     * @param string|null $nonce Reset password nonce
     * @return \Cake\Http\Response|null|void Redirects on successful password reset, renders view otherwise.
     */
    public function resetPassword(?string $nonce = null)
    {
        $user = $this->Users->findByNonce($nonce)->first();

        // If nonce cannot find the user, or nonce is expired, prompt for re-reset password
        if (!$user || $user->nonce_expiry < DateTime::now()) {
            $this->Flash->error('Your link is invalid or expired. Please try again.');

            return $this->redirect(['action' => 'forgetPassword']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            // Used a different validation set in Model/Table file to ensure both fields are filled
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'resetPassword']);

            // Also clear the nonce-related fields on successful password resets.
            // This ensures that the reset link can't be used a second time.
            $user->nonce = null;
            $user->nonce_expiry = null;

            if ($this->Users->save($user)) {
                $this->Flash->success('The password has been successfully reset. Please login with new password. ');

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('The password cannot be reset. Please try again.');
        }

        $this->set(compact('user'));
    }

    /**
     * Change Password method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changePassword(?string $id = null)
    {
        $user = $this->Users->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Used a different validation set in Model/Table file to ensure both fields are filled
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'resetPassword']);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');

                return $this->redirect(['controller' => 'Users', 'action' => 'index']);
            }
            $this->Flash->error('The user could not be saved. Please, try again.');
        }
        $this->set(compact('user'));
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirect to location before authentication
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // if user passes authentication, grant access to the system
        if ($result && $result->isValid()) {
            $admin_manager = [1, 2];
            $contractor = 3;

            // Check if the user's role is in the allowed roles array
            if (in_array($this->request->getAttribute('identity')->role_id, $admin_manager)) {
                // $this->Flash->error(__('You are not authorized to access this area.'));
                return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
            } elseif (($this->request->getAttribute('identity')->role_id == $contractor)) {
                return $this->redirect(['controller' => 'Bookings', 'action' => 'indexById']);
            }

            // set a fallback location in case user logged in without triggering 'unauthenticatedRedirect'
            $fallbackLocation = ['controller' => 'Pages', 'action' => 'Home'];

            // and redirect user to the location they're trying to access
            return $this->redirect($this->Authentication->getLoginRedirect() ?? $fallbackLocation);
        }

        // display error if user submitted their credentials but authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Email address and/or Password is incorrect. Please try again. ');
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function logout()
    {
        // We only need to log out a user when they're logged in
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();

            $this->Flash->success('You have been logged out successfully. ');
        }

        // Otherwise just send them to the login page
        return $this->redirect(['controller' => 'Auth', 'action' => 'login']);
    }

    public function allowEntry(): bool
    {
        $authRoleId = $this->request->getAttribute('identity')->role_id;

        $admin_manager = [1, 2];

        return in_array($authRoleId, $admin_manager);
    }

    private function generateRandomPassword(): string
    {
        $length = 8;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $password = '';

        // Ensure password contains at least one uppercase, one lowercase, one number, and one special character
        $password .= chr(rand(65, 90)); // Uppercase
        $password .= chr(rand(97, 122)); // Lowercase
        $password .= chr(rand(48, 57)); // Number
        $password .= chr(rand(33, 47)); // Special character

        // Fill the rest of the password length
        for ($i = 4; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }

        return str_shuffle($password);
    }

    public function forceResetPassword(?string $id = null)
    {
        // Ensure the currently logged-in user is an admin (role = 1)
        if ($this->request->getAttribute('identity')->role_id !== 1) {
            $this->Flash->error('You do not have permission to access this feature.');
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }

        // Find the user by ID
        $user = $this->Users->get($id);

        if (!$user) {
            $this->Flash->error('User not found.');
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }

        // Generate a random password with the required complexity
        $randomPassword = $this->generateRandomPassword();

        // Set the nonce and expiry date for the password reset
        $user->nonce = Security::randomString(128);
        $user->nonce_expiry = new DateTime('+3 days');

        // Hash the new random password and assign it to the user
        $user->password = $randomPassword;

        // Save the user entity
        if ($this->Users->save($user)) {
            // Send the reset password email
            $mailer = new Mailer('default');

            $mailer
                ->setFrom(['booking.no-reply@pramspa.au' => 'Pram Spa'])
                ->setEmailFormat('html')
                ->setTo($user->email)
                ->setSubject('Reset Your Account Password');


            $mailer
                ->viewBuilder()->setHelpers(['ContentBlocks.ContentBlock'])
                ->setTemplate('reset_password');


            // Pass necessary variables to the email template
            $mailer->setViewVars([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'nonce' => $user->nonce,
                'email' => $user->email

            ]);
            if (!$mailer->deliver()) {
                // Just in case something goes wrong when sending emails
                $this->Flash->error('We have encountered an issue when sending the email. Please try again. ');

                return $this->render(); // Skip the rest of the controller and render the view
            }
        } else {
            // Just in case something goes wrong when saving nonce and expiry
            $this->Flash->error('We are having issues to force reset this password. Please try again.');

            return $this->render(); // Skip the rest of the controller and render the view
        }
        $this->Flash->success('The staff has been forced to reset their password. An email has been sent to their inbox.');

        return $this->redirect(['controller' => 'Users', 'action' => 'index']);
    }
}
