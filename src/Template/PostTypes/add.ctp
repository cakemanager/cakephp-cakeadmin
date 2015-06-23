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
?>

<h3><?= $type['alias'] ?></h3>

<?= $this->Html->link('All ' . $type['alias'], ['action' => 'index', 'type' => $type['slug']]) ?>

<hr>
<?= $this->Form->create($entity, $type['formFields']['_create']); ?>
<fieldset>
    <legend><?= __('Add ' . $type['alias']) ?></legend>
    <?php
    foreach ($type['formFields'] as $field => $options) {
        if(substr($field, 0,1) !== '_') {
            if(in_array($options['on'], ['both', 'add'])) {
                echo $this->Form->input($field, $options);
            }
        }
    }
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
