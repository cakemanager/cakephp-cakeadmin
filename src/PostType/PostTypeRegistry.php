<?php

namespace Bakkerij\CakeAdmin\PostType;


use Bakkerij\CakeAdmin\PostType\Exception\MissingPostTypeException;
use Cake\Core\App;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;

class PostTypeRegistry
{

    /**
     * List of PostTypes
     *
     * @var array
     */
    protected static $list;

    public static function register($class)
    {
        self::$list[] = $class;
    }

    public static function get($class)
    {
        $list = (array)self::$list;

        if (in_array($class, $list)) {
            $className = $class;
        } else {
            throw new MissingPostTypeException(['posttype' => Inflector::pluralize($class)]);
        }

        $transformer = App::className(Inflector::pluralize($className), 'PostType', 'PostType');

        if ($transformer === false) {
            throw new MissingPostTypeException(['posttype' => Inflector::pluralize($className)]);
        }

        return new $transformer;
    }

    public static function getBySlug($slug)
    {
        $all = self::getAll();

        foreach($all as $class => $type) {
            if($type->slug() === $slug) {
                return self::get($class);
            }
        }

        throw new MissingPostTypeException(['posttype' => $slug]);
    }

    /**
     * @return PostType[]
     */
    public static function getAll()
    {
        $list = (array)self::$list;

        $all = [];

        foreach($list as $class) {
            $all[$class] = self::get($class);
        }

        return $all;
    }

}