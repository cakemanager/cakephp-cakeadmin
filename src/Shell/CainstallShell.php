<?php
namespace CakeAdmin\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

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
        if ($this->_tableExists('cake_admin_phinxlog')) {
            $this->out('<info>The table already exists. No migration executed</info>');
        } else {
            $this->execute('call cake migrations migrate -p CakeAdmin');
            if ($this->_tableExists('cake_admin_phinxlog')) {
                $this->out('<info>Migrating CakeAdmin Tables completed!</info>');
            } else {
                $this->out('<error>
                        Migrating CakeAdmin could not be completed.
                        Run the migration manually with: $ bin/cake migrations migrate -p CakeAdmin
                </error>');
            }
        }
        $this->hr();

        // Notifier Migration
        $this->out('Migrating Notifier Tables...');
        if ($this->_tableExists('cake_admin_phinxlog')) {
            $this->out('<info>The table already exists. No migration executed</info>');
        } else {
            $this->execute('call cake migrations migrate -p Notifier');
            if ($this->_tableExists('cake_admin_phinxlog')) {
                $this->out('<info>Migrating Notifier Tables completed!</info>');
            } else {
                $this->out('<error>
                        Migrating Notifier could not be completed.
                        Run the migration manually with: $ bin/cake migrations migrate -p Notifier
                </error>');
            }
        }
        $this->hr();

        // Settings Migration
        $this->out('Migrating Settings Tables...');
        if ($this->_tableExists('cake_admin_phinxlog')) {
            $this->out('<info>The table already exists. No migration executed</info>');
        } else {
            $this->execute('call cake migrations migrate -p Settings');
            if ($this->_tableExists('cake_admin_phinxlog')) {
                $this->out('<info>Migrating Settings Tables completed!</info>');
            } else {
                $this->out('<error>
                        Migrating Settings could not be completed.
                        Run the migration manually with: $ bin/cake migrations migrate -p Settings
                </error>');
            }
        }
        $this->hr();

        $createAdmin = $this->in('Do you want to create your first administrator?', ['Y', 'N'], 'Y');

        if ($createAdmin) {
            $this->out('Generating a new administrator...');
            $this->dispatchShell('admin');
        }
    }

    protected function execute($command)
    {
        return exec($command);
    }

    protected function _tableExists($table)
    {
        $db = ConnectionManager::get('default');
        $tables = $db->schemaCollection()->listTables();

        return in_array($table, $tables);
    }
}
