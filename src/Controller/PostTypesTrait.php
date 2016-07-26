<?php

namespace Bakkerij\CakeAdmin\Controller;


trait PostTypesTrait
{

    public function setPostTypeActions()
    {
        $actions = $this->postType->actions();

        foreach($actions as $action => $state) {
            if($state) {
                $this->Crud->enable($action);
            } else {
                $this->Crud->disable($action);
            }
        }
    }

    public function setModelClass()
    {
        $this->modelClass = $this->postType->model();
    }

}