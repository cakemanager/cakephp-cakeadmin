<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>

        <?= $this->Menu->render('cakeadmin_main'); ?>
    </ul>
</nav>
<div class="index large-9 medium-8 columns content">
    <h3><?= __('View all {0}', [$this->PostType->name('plural')]) ?></h3>

    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <?php foreach ($this->PostType->tableColumns() as $column => $options): ?>
                <th><?= $this->Paginator->sort($column) ?></th>
            <?php endforeach; ?>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <?php foreach ($this->PostType->tableColumns() as $column => $options): ?>
                    <td><?= h($item->get($options['get'])) ?></td>
                <?php endforeach; ?>
                <td class="actions">
                    <?= $this->PostType->viewLink($item) ?>
                    <?= $this->PostType->editLink($item) ?>
                    <?= $this->PostType->deleteLink($item) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>

    <!--    --><?php //foreach($items as $item): ?>
    <!---->
    <!--        --><?php //debug($item) ?>
    <!---->
    <!--    --><?php //endforeach; ?>
</div>
