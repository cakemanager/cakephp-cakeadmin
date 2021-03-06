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

use CakeAdmin\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * PostTypes Controller
 *
 * @property \CakeAdmin\Model\Table\PostTypesTable $PostTypes
 */
class PostTypesController extends AppController
{
    /**
     * Model that will be used (so none).
     * @var array
     */
    public $uses = [];

    /**
     * initialize
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Utils.Menu');
        $this->loadComponent('Utils.Search');

        $this->helpers['Utils.Search'] = [];
    }

    /**
     * beforeFilter event.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $slug = lcfirst($this->request->params['type']);

        $this->type = $this->PostTypes->getOption($slug);

        if (!$this->type) {
            throw new Exception("The PostType is not registered");
        }

        $this->Model = TableRegistry::get($this->type['model']);

        // making the current item active
        $this->Menu->active($this->type['alias']);

        parent::beforeFilter($event);
    }

    /**
     * beforeRender event.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $this->set('type', $this->type);
        $this->set('title', $this->type['name']);
    }

    /**
     * Index method
     *
     * @param string $type The requested PostType.
     * @return void
     */
    public function index($type = null)
    {
        $this->_validateActionIsEnabled('index');

        $this->_event('beforeIndex');

        $this->paginate = [
            'limit' => 25,
            'order' => [
                ucfirst($this->Model->alias()) . '.id' => 'asc'
            ]
        ];

        foreach ($this->type['filters'] as $key => $value) {
            if (is_array($value)) {
                $this->Search->addFilter($key, $value);
            } else {
                $this->Search->addFilter($value);
            }
        }

        $query = $this->_callQuery($this->Model->find('all'));
        $query = $this->Search->search($query);

        $this->set('data', $this->paginate($query));

        $this->_event('afterIndex');
    }

    /**
     * View method
     *
     * @param string $type The requested PostType.
     * @param string|null $id Post Type id
     * @return void
     */
    public function view($type = null, $id = null)
    {
        $this->_validateActionIsEnabled('view');

        $this->_event('beforeView', [
            'id' => $id
        ]);

        $data = $this->Model->get($id, [
            'contain' => $this->type['contain']
        ]);
        $this->set('data', $data);

        $this->_event('afterView', [
            'id' => $id
        ]);
    }

    /**
     * Add method
     *
     * @param string $type The requested PostType.
     * @return void|\Cake\Network\Response
     */
    public function add($type = null)
    {
        $this->_validateActionIsEnabled('add');

        $this->_event('beforeAdd');

        $entity = $this->Model->newEntity()->accessible('*', true);
        if ($this->request->is('post')) {
            $entity = $this->Model->patchEntity($entity, $this->request->data());
            if ($this->Model->save($entity)) {
                $this->Flash->success(__d('CakeAdmin', 'The {0} has been saved.', [$this->type['singularAliasLc']]));
                return $this->redirect(['action' => 'index', 'type' => $this->type['name']]);
            } else {
                $this->Flash->error(__d('CakeAdmin', 'The {0} could not be saved. Please, try again.', [$this->type['singularAliasLc']]));
            }
        }

        $this->_loadAssociations();

        $this->set(compact('type', 'entity'));

        $this->_event('afterAdd');
    }

    /**
     * Edit method
     *
     * @param string $type The requested PostType.
     * @param string|null $id Post Type id
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function edit($type = null, $id = null)
    {
        $this->_validateActionIsEnabled('edit');

        $this->_event('beforeEdit', [
            'id' => $id
        ]);

        $query = $this->_callQuery($this->Model->findById($id));
        $entity = $query->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $entity->accessible('*', true);
            $entity = $this->Model->patchEntity($entity, $this->request->data());
            if ($this->Model->save($entity)) {
                $this->Flash->success(__d('CakeAdmin', 'The {0} has been edited.', [$this->type['singularAliasLc']]));
                return $this->redirect(['action' => 'index', 'type' => $this->type['name']]);
            } else {
                $this->Flash->error(__d('CakeAdmin', 'The {0} could not be edited. Please, try again.', [$this->type['singularAliasLc']]));
            }
        }

        $this->_loadAssociations();

        $this->set(compact('type', 'entity'));

        $this->_event('afterEdit', [
            'id' => $id
        ]);
    }

    /**
     * Delete method
     *
     * @param string $type The requested PostType.
     * @param string|null $id Post Type id
     * @return void|\Cake\Network\Response
     */
    public function delete($type = null, $id = null)
    {
        $this->_validateActionIsEnabled('delete');

        $this->_event('beforeDelete', [
            'id' => $id
        ]);

        $entity = $this->Model->get($id);

        $this->request->allowMethod(['post', 'delete']);

        if ($this->Model->delete($entity)) {
            $this->Flash->success(__d('CakeAdmin', 'The {0} has been deleted.', [$this->type['singularAliasLc']]));
        } else {
            $this->Flash->error(__d('CakeAdmin', 'The {0} could not be deleted. Please, try again.', [$this->type['singularAliasLc']]));
        }

        $this->_event('afterDelete', [
            'id' => $id
        ]);

        return $this->redirect(['action' => 'index', 'type' => $this->type['name']]);
    }

    /**
     * Uses the query-callable from the PostType.
     *
     * @param Query $query Query object.
     * @return Query Query object.
     */
    protected function _callQuery($query)
    {
        $query->contain($this->type['contain']);
        $extQuery = $this->type['query'];
        return $extQuery($query);
    }

    /**
     * Dynamically loads all associations of the model.
     *
     * @return void
     */
    protected function _loadAssociations()
    {
        foreach ($this->Model->associations()->getIterator() as $association => $assocData) {
            $this->set(Inflector::variable($assocData->alias()), $this->Model->{$association}->find('list')->toArray());
        }
    }

    /**
     * Validates if the action is enabled. If not an exception will be raised.
     *
     * @param string $action Chosen action to check on.
     * @return void
     */
    protected function _validateActionIsEnabled($action)
    {
        if (!$this->_actionIsEnabled($action)) {
            throw new Exception('This action is disabled for the PostType ' . $this->type['alias']);
        }
    }

    /**
     * Checks if the action is enabled.
     *
     * @param string $action Chosen action to check on.
     * @return bool
     */
    protected function _actionIsEnabled($action)
    {
        $actions = $this->type['actions'];

        if (array_key_exists($action, $actions)) {
            return $actions[$action];
        }
        return true;
    }

    /**
     * Fires an event with the PostType-prefix.
     *
     * @param string $action Current action.
     * @param array $data data that should be sent with the event.
     * @return void
     */
    protected function _event($action, $data = [])
    {
        $_event = new Event('Controller.PostTypes.' . $this->type['name'] . '.' . $action, $this, $data);
        $this->eventManager()->dispatch($_event);
    }
}
