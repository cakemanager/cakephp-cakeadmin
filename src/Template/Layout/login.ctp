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

$this->assign('title', $title);
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('CakeAdmin.base') ?>
    <?= $this->Html->css('CakeAdmin.cake') ?>
    <?= $this->Html->css('CakeAdmin.custom') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<header>
    <div class="header-title">
        <span><?= $this->fetch('title') ?></span>
    </div>
    <div class="header-help">
        <span><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></span>
        <span><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></span>
    </div>
</header>
<div id="container">

    <div id="content">
        <?= $this->Flash->render() ?>

        <div class="row">
            <div class="index large-12 medium-12 columns">
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
    <footer>
    </footer>
</div>
</body>
</html>
