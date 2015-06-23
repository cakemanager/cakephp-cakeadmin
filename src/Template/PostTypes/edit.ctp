<?php
?>

<h3><?= $type['alias'] ?></h3>

<?= $this->Html->link('All ' . $type['alias'], ['action' => 'index', 'type' => $type['slug']]) ?>

<hr>

<?= $this->Form->create($entity); ?>
<fieldset>
    <legend><?= __('Edit ' . $type['alias']) ?></legend>
    <?php
    foreach ($type['formFields'] as $field => $options) {
        if (strpos($field, '_', 0) === false) {
            if (in_array($options['on'], ['both', 'edit'])) {
                echo $this->Form->input($field, $options);
            }
        }
    }
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
