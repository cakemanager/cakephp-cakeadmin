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
?>

<?= $this->PostTypes->header() ?>

<?= $this->PostTypes->indexButton() ?>

<hr>
<?= $this->PostTypes->createForm($entity) ?>
<fieldset>
    <?= $this->PostTypes->fieldset([
        'on' => ['both', 'ad']
    ]) ?>
</fieldset>
<?= $this->PostTypes->submitForm() ?>
<?= $this->PostTypes->endForm() ?>
