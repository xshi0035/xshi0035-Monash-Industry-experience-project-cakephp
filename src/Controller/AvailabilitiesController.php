<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Availabilities Controller
 *
 * @property \App\Model\Table\AvailabilitiesTable $Availabilities
 */
class AvailabilitiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Availabilities->find()
            ->contain(['Locations']);
        $availabilities = $this->paginate($query);

        $this->set(compact('availabilities'));
    }

    /**
     * View method
     *
     * @param string|null $id Availability id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $availability = $this->Availabilities->get($id, contain: ['Locations']);
        $this->set(compact('availability'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($locationId = null)
    {
        $locationId = $this->request->getQuery('location_id');

        $availability = $this->Availabilities->newEmptyEntity();

        // Default value for start and end time 
        $startTime = strtotime('05:00');
        $endTime = strtotime('20:00');

        $timeRange = ($endTime - $startTime) / 60;
        $options = [];

        for ($i = 0; $i <= $timeRange; $i += 15) {  // 15-minute intervals
            $time = strtotime('+' . $i . ' minutes', $startTime);
            $formattedTime = date('H:i', $time);  // Convert to 24-hour format

            $options[$formattedTime] = $formattedTime;
        }

        // Ensure the last element (endTime) is included
        $formattedEndTime = date('H:i', $endTime);
        $options[$formattedEndTime] = $formattedEndTime;

        if ($this->request->is('post')) {
            $availability = $this->Availabilities->patchEntity($availability, $this->request->getData());
            $availability->location_id = $locationId;  // Set location_id

            if ($availability->start_time >= $availability->end_time) {
                $this->Flash->error(__('Start time must be before end time'));
            } else if ($this->Availabilities->save($availability)) {
                $this->Flash->success(__('The availability has been saved.'));

                return $this->redirect(['controller' => 'Locations', 'action' => 'view', $locationId]);
            }
            $this->Flash->error(__('The availability could not be saved. Please, try again.'));
        }

        $this->set('location_id', $locationId);
        $this->set(compact('availability', 'startTime', 'endTime', 'options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Availability id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $availability = $this->Availabilities->get($id, contain: []);
        $locationId = $availability->location_id;

        // selected start and end time
        $selectedStartTime = $availability->start_time->i18nFormat('HH:mm');
        $selectedEndTime = $availability->end_time->i18nFormat('HH:mm');
        // dd($selectedStartTime->i18nFormat('HH:mm'));


        // Default value for start and end time 
        $startTime = strtotime('05:00');
        $endTime = strtotime('20:00');

        $timeRange = ($endTime - $startTime) / 60;
        $options = [];

        for ($i = 0; $i <= $timeRange; $i += 15) {  // 15-minute intervals
            $time = strtotime('+' . $i . ' minutes', $startTime);
            $formattedTime = date('H:i', $time);  // Convert to 24-hour format

            $options[$formattedTime] = $formattedTime;
        }

        // Ensure the last element (endTime) is included
        $startTime = date('H:i', $startTime);
        $endTime = date('H:i', $endTime);
        $options[$endTime] = $endTime;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $availability = $this->Availabilities->patchEntity($availability, $this->request->getData());

            if ($availability->start_time >= $availability->end_time) {
                $this->Flash->error(__('Start time must be before end time'));
            } else if ($this->Availabilities->save($availability)) {
                $this->Flash->success(__('The availability has been saved.'));

                return $this->redirect(['controller' => 'Locations', 'action' => 'view', $locationId]);
            }
            $this->Flash->error(__('The availability could not be saved. Please, try again.'));
        }

        $this->set(compact('availability', 'options', 'selectedStartTime', 'selectedEndTime'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Availability id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $availability = $this->Availabilities->get($id, contain: ['Locations']);
        $locationId = $availability->location->id;
        $this->request->allowMethod(['post', 'delete']);
        if ($this->Availabilities->delete($availability)) {
            $this->Flash->success(__('The availability has been deleted.'));

            return $this->redirect(['controller' => 'Locations', 'action' => 'view', $locationId]);
        } else {
            $this->Flash->error(__('The availability could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
