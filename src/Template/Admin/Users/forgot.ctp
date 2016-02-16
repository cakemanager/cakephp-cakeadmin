<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __d('CakeAdmin', 'Forgot password') ?></legend>
        <?= $this->Form->input('email') ?>
    </fieldset>
    <?= $this->Form->button(__d('CakeAdmin', 'Request')); ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Login', ['action' => 'login']); ?>
</div>