<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\Test\App\Model\Table;

use Cake\ORM\Table;

/**
 * Book table class
 */
class BooksTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('authors');
    }

    public function postType()
    {
        return [
            'model' => 'Books',
            'menu' => false,
            'menuWeight' => 25,
            'slug' => 'books',
            'name' => 'Cake Books',
            'alias' => 'CakeBooks',
            'aliasLc' => 'cakebooks',
            'singularAlias' => 'Cake Book',
            'singularAliasLc' => 'cake book',
            'description' => 'Books are written by authors.',
            'actions' => [
                'index' => false,
                'add' => false,
                'edit' => false,
                'view' => false,
                'delete' => false
            ],
            'filters' => [
                'title'
            ],
            'contain' => [
                'authors'
            ],
            'query' => function ($query) {
                return $query;
            },
            'tableColumns' => [
                'id',
                'author_id',
                'title',
                'body',
                'published'
            ],
            'formFields' => [
                'id',
                'author_id',
                'title'
            ]
        ];
    }
}
