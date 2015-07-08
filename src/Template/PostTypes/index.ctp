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

$this->loadHelper('CakeAdmin.PostTypes');

$this->PostTypes->type($type);
$this->PostTypes->data($data);
?>

<?= $this->PostTypes->header() ?>

<?= $this->PostTypes->addButton() ?>

<hr>
<?= $this->PostTypes->searchFilter($searchFilters) ?>

<table cellpadding="0" cellspacing="0">
    <thead>
    <?= $this->PostTypes->tableHead() ?>
    </thead>
    <tbody>
    <?= $this->PostTypes->tableBody() ?>
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