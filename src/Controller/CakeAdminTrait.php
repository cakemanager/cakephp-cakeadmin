<?php

namespace Bakkerij\CakeAdmin\Controller;


use Bakkerij\CakeAdmin\PostType\PostTypeRegistry;
use Cake\Core\Configure;
use Cake\Event\Event;
use Knp\Menu\MenuItem;

trait CakeAdminTrait
{

    public function initializeCakeAdmin()
    {
        $namespace = 'App\CakeAdmin';

        if(class_exists($namespace)) {
            $init = new $namespace();

            $this->eventManager()->on($init);
        }

        $this->__trigger('CakeAdmin.Controller.startup');
    }
    
    public function buildMenu()
    {
        /** @var MenuItem $menu */
        $menu = $this->Menu->get('cakeadmin_main');

        $menu->addChild('Dashboard', ['uri' => [
            'plugin' => 'Bakkerij/CakeAdmin',
            'prefix' => 'admin',
            'controller' => 'Dashboard',
            'action' => 'index'
        ]]);

        $this->addPostTypesToMenu();

        $this->addConfigurationsToMenu();
    }

    public function addPostTypesToMenu()
    {
        /** @var MenuItem $menu */
        $menu = $this->Menu->get('cakeadmin_main');

        $postTypes = PostTypeRegistry::getAll();

        foreach ($postTypes as $postType) {
            $menu->addChild($postType->name(), ['uri' => [
                'plugin' => 'Bakkerij/CakeAdmin',
                'prefix' => 'admin',
                'controller' => 'PostTypes',
                'action' => 'index',
                'type' => $postType->slug()
            ]]);
        }
    }

    public function addConfigurationsToMenu()
    {
        /** @var MenuItem $menu */
        $menu = $this->Menu->get('cakeadmin_main');

        $configurations = (array) Configure::read('CA.menu.main');

        foreach($configurations as $label => $options) {
            $menu->addChild($label, $options);
        }
    }

    private function __trigger($event, array $data = [])
    {
        $event = new Event($event, $this, $data);
        $this->eventManager()->dispatch($event);
    }
}