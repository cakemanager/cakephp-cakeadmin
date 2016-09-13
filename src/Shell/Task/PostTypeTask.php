<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 20-7-16
 * Time: 20:37
 */

namespace Bakkerij\CakeAdmin\Shell\Task;


use Bake\Shell\Task\SimpleBakeTask;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

class PostTypeTask extends SimpleBakeTask
{

    public $pathFragment = 'PostType/';

    public function main($name = null)
    {
        $this->BakeTemplate->set('ptname', $this->ptname($name));
        $this->BakeTemplate->set('ptslug', $this->ptslug($name));
        $this->BakeTemplate->set('ptmodel', $this->ptmodel($name));

        parent::main($name);
    }

    /**
     * Get the generated object's name.
     *
     * @return string
     */
    public function name()
    {
        return 'postType';
    }

    /**
     * Get the generated object's filename without the leading path.
     *
     * @param string $name The name of the object being generated
     * @return string
     */
    public function fileName($name)
    {
        return $name . 'PostType.php';
    }

    /**
     * Get the template name.
     *
     * @return string
     */
    public function template()
    {
        return 'Bakkerij/CakeAdmin.postType';
    }

    public function ptname($name)
    {
        return Inflector::humanize($name);
    }

    public function ptslug($name)
    {
        return Inflector::dasherize(Text::slug($name));
    }

    public function ptmodel($name)
    {
        $model = Inflector::pluralize($name);

        if ($this->param('plugin')) {
            $model = $this->param('plugin') . '.' . $model;
        }

        return $model;
    }
}