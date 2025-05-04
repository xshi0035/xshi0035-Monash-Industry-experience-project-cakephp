<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/5/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
        $this->loadComponent('Authentication.Authentication');
    }

    public function disallowEntry(): bool
    {
        $authRoleId = $this->request->getAttribute('identity')->role_id;

        //Role: Inactive aren't allowed access to anything.
        $disallowed = [4];

        return in_array($authRoleId, $disallowed);

    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Check if the user is logged in and if their role is disallowed
        if ($this->request->getAttribute('identity') && $this->disallowEntry()) {
            // Log the user out
            $this->Authentication->logout();

            // Flash a message indicating that access is denied
            $this->Flash->error('You do not have access to this system.');

            // Redirect them to Bookings/selectLocation
            return $this->redirect(['controller' => 'Bookings', 'action' => 'selectLocation']);
        }
    }
}
