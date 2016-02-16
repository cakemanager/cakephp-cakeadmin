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

use Cake\Core\Configure;

$this->set('title', __d('CakeAdmin', 'Login'));

?>
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
