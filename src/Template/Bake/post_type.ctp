<?php

namespace <%= $namespace %>\PostType;

use Bakkerij\CakeAdmin\PostType\PostType;

/**
 * <%= $name %> PostType
 */
class <%= $name %>PostType extends PostType
{

    public function initialize()
    {
        $this->name('<%= $ptname %>');
        $this->slug('<%= $ptslug %>');

        $this->model('<%= $ptmodel %>');
    }

}