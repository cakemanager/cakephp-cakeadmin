<?php
namespace Bakkerij\CakeAdmin\Controller\Component;

use Bakkerij\CakeAdmin\PostType\PostTypeRegistry;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;

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

    public function loadPostTypesFromConfig()
    {
        $list = (array) Configure::read('CA.postTypes');

        foreach($list as $key => $value) {
            PostTypeRegistry::register($key, $value);
        }
    }
}
