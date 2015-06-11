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
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

//debug($type);
?>

<h3><?= $type['name'] ?></h3>

<?= $this->Html->link('New ' . Inflector::singularize($type['alias']), ['action' => 'add', 'type' => $type['slug']]) ?>

<hr>
<?= ($searchFilters ? $this->Search->filterForm($searchFilters) : null) ?>

<table cellpadding="0" cellspacing="0">
    <thead>
    <tr>

        <?php foreach ($type['tableColumns'] as $column => $options) : ?>
            <th><?= $this->Paginator->sort($column) ?></th>
        <?php endforeach; ?>
        <th class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $item): ?>
        <tr>
            <?php foreach ($type['tableColumns'] as $column => $options) : ?>
                <td>
                    <?= $item->get($column) ?>
                </td>
            <?php endforeach; ?>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', 'type' => $type['slug'], $item->get('id')]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', 'type' => $type['slug'], $item->get('id')]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', 'type' => $type['slug'], $item->get('id')], ['confirm' => __('Are you sure you want to delete # {0}?', $item->get('id'))]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')); ?>
        <?= $this->Paginator->numbers(); ?>
        <?= $this->Paginator->next(__('next') . ' >'); ?>
    </ul>
    <p><?= $this->Paginator->counter(); ?></p>
</div>

<?php
//debug($data);
?>
