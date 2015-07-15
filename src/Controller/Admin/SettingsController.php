<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Hash;
use CakeAdmin\Controller\AppController;
use Settings\Core\Setting;

/**
 * Settings Controller
 *
 * @property \Settings\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController
{

    /**
     * beforeFilter
     *
     * beforeFilter event.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->loadModel('Settings.Configurations');

        $this->prefixes = Configure::read('Settings.Prefixes');

        $this->Menu->active('ca.settings');
        $this->Menu->area('navbar');

        foreach ($this->prefixes as $prefix => $alias) {
            $this->Menu->add($alias, [
                'url' => [
                    'action' => 'index', $prefix,
                ]
            ]);
        }
    }

    /**
     * index action
     *
     * Shows all settings with the specific prefix.
     *
     * @param string $key The prefix.
     * @return void|\Cake\Network\Respose
     * @throws NotFoundException
     */
    public function index($key = null)
    {
        if (!$key) {
            $key = 'App';
        }
        $this->Menu->active($this->prefixes[$key]);

        if (!$this->__prefixExists($key)) {
            throw new NotFoundException("The prefix-setting " . $key . " could not be found");
        }

        $prefix = Hash::get($this->prefixes, ucfirst($key));

        $settings = $this->Configurations->find('all')->where([
            'name LIKE' => $key . '%',
            'editable' => 1,
        ])->order(['weight', 'id']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $settings = $this->Configurations->patchEntities($settings, $this->request->data);
            foreach ($settings as $setting) {
                $this->Flash->success('The settings has been saved.');
                if (!$this->Configurations->save($setting)) {
                    $this->Flash->error('The settings could not be saved. Please, try again.');
                }
            }
            Setting::clear(true);
            Setting::autoLoad();
            return $this->redirect([]);
        }

        $this->set(compact('prefix', 'settings'));
    }

    /**
     * _prefixExists
     *
     * Checks if a prefix exists.
     *
     * @param string $prefix The prefix.
     * @return bool
     */
    private function __prefixExists($prefix)
    {
        if (Hash::get($this->prefixes, ucfirst($prefix)) == null) {
            return false;
        }

        return true;
    }
}
