<?php
namespace CakeAdmin\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;

/**
 * CakeAdmin component
 */
class CakeAdminComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function administrators($field = null)
    {
        $model = TableRegistry::get('CakeAdmin.Administrators');

        $query = $model->find('all');

        if($field) {
            $model->displayField($field);
            $query->find('list');
        }

        $result = $query->toArray();

        return $result;
    }
}
