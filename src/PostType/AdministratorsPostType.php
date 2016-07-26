<?php

namespace Bakkerij\CakeAdmin\PostType;

use Bakkerij\CakeAdmin\PostType\PostType;

/**
 * Administrators PostType
 */
class AdministratorsPostType extends PostType
{

    public function initialize()
    {
        $this->name('Administrators');
        $this->slug('administrators');

        $this->model('Bakkerij/CakeAdmin.Administrators');

        $this->tableColumns([
            'name',
            'email',
            'active',
            'created',
            'modified'
        ]);
    }

}