<?php
$this->set('title', 'Dashboard');
?>

<h3>Dashboard</h3>

<div class="row">
    <div class="columns large-12 top">
        <?= $this->cell('CakeAdmin.Dashboard::welcome') ?>
    </div>
</div>

<div class="row">
    <div class="columns large-6 left">
        <?= $this->cell('CakeAdmin.Dashboard::gettingStarted') ?>
        <?= $this->cell('CakeAdmin.Dashboard::plugins'); ?>
        <?= $this->cell('CakeAdmin.Dashboard::gettingHelp'); ?>
    </div>
    <div class="columns large-6 right">
        <?= $this->cell('CakeAdmin.Dashboard::latestPosts'); ?>
    </div>
</div>

<div class="row">
    <div class="columns large-12 bottom">
        <?= $this->cell('CakeAdmin.Dashboard::aboutUs') ?>
    </div>
</div>