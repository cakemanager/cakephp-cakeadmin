<?php

namespace Bakkerij\CakeAdmin\PostType\Exception;

use Cake\Core\Exception\Exception;

class MissingPostTypeException extends Exception
{
    /**
     * {@inheritDoc}
     */
    protected $_messageTemplate = 'PostType %s could not be found, or is not accessible.';

}