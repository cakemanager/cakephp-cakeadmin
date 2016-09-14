<?php
use Cake\Core\Configure;

$this->set('title', __d('CakeAdmin', 'Login'));
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
</nav>
<div class="index large-9 medium-8 columns content">
    <h3><?= __('Login') ?></h3>
    <div class="users form">
        <?= $this->Flash->render('auth') ?>
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __d('CakeAdmin', 'Login') ?></legend>
            <?= $this->Form->input(Configure::read('CA.fields.username')) ?>
            <?= $this->Form->input(Configure::read('CA.fields.password'), ['value' => '']) ?>
        </fieldset>
        <?= $this->Form->button(__d('CakeAdmin', 'Login')); ?>
        <?= $this->Form->end() ?>
        <?= $this->Html->link(__d('CakeAdmin', 'Forgot password'), ['action' => 'forgot']); ?>
    </div>
</div>
