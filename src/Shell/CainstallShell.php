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
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeAdmin\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Migrations\Migrations;

/**
 * Cainstall shell command.
 */
class CainstallShell extends Shell
{

    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        // CakeAdmin Migration
        $this->out('Migrating CakeAdmin Tables...');
        $this->migrate('CakeAdmin');
        $this->out('<info>Migrating CakeAdmin Tables completed!</info>');
        $this->hr();

        // Notifier Migration
        $this->out('Migrating Notifier Tables...');
        $this->migrate('Notifier');
        $this->out('<info>Migrating Notifier Tables completed!</info>');
        $this->hr();

        // Settings Migration
        $this->out('Migrating Settings Tables...');
        $this->migrate('Settings');
        $this->out('<info>Migrating Settings Tables completed!</info>');
        $this->hr();

        $createAdmin = $this->in('Do you want to create your first administrator?', ['Y', 'n'], 'Y');

        if ($createAdmin === 'Y') {
            $this->out('Generating a new administrator...');
            $this->dispatchShell('admin');
        }
    }

    /**
     * Migrates the given plugin.
     *
     * @param string $plugin Plugin name.
     * @return bool
     */
    protected function migrate($plugin)
    {
        $migrations = new Migrations();

        return $migrations->migrate(['plugin' => $plugin]);
    }

    /**
     * Checks if the table exists.
     *
     * @param string $table Plugin name.
     * @return bool
     */
    protected function _tableExists($table)
    {
        $db = ConnectionManager::get('default');
        $tables = $db->schemaCollection()->listTables();

        return in_array($table, $tables);
    }
}
