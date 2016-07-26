<?php
namespace Bakkerij\CakeAdmin\Controller\Admin;

use Bakkerij\CakeAdmin\Controller\AppController;
use Bakkerij\CakeAdmin\Controller\PostTypesTrait;
use Bakkerij\CakeAdmin\PostType\PostType;
use Bakkerij\CakeAdmin\PostType\PostTypeRegistry;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Crud\Controller\Component\CrudComponent;

/**
 * PostType Controller
 *
 */
class PostTypesController extends AppController
{

    use PostTypesTrait;

    /**
     * @var PostType
     */
    protected $postType;

    /**
     * @var CrudComponent
     */
    protected $Crud;

    public function initialize()
    {
        parent::initialize();

        $this->postType = PostTypeRegistry::getBySlug($this->request->param('type'));

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ]
        ]);

        $this->setPostTypeActions();
        $this->setModelClass();
    }

    public function beforeFilter(Event $event)
    {
        $this->Crud->action()->viewVar('items');

        parent::beforeFilter($event);
    }

    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->helpers(['Bakkerij/CakeAdmin.PostType' => [
            'data' => $this->postType
        ]]);

        parent::beforeRender($event);
    }

}
