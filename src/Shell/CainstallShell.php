<?php
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
     * @return bool|int Success or error code.
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

    protected
    function migrate($plugin)
    {
        $migrations = new Migrations();

        return $migrations->migrate(['plugin' => $plugin]);

        unset($migrations);
    }

    protected
    function _tableExists($table)
    {
        $db = ConnectionManager::get('default');
        $tables = $db->schemaCollection()->listTables();

        return in_array($table, $tables);
    }
}
