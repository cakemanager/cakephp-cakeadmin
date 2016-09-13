<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Menu') ?></li>

        <?= $this->Menu->render('cakeadmin_main'); ?>
    </ul>
</nav>
<div class="index large-9 medium-8 columns content">
    <h3><?= __('Edit {0}', [$this->PostType->name('singular')]) ?></h3>
</div>
