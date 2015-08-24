<?php
namespace CakeAdmin\Shell;

use Cake\Console\Shell;

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
    public function main() {

        $this->out('Migrating CakeAdmin Tables...');
        $this->execute('call cake migrations migrate -p CakeAdmin');
        $this->out('<info>Migrating CakeAdmin Tables completed!</info>');
        $this->hr();

        $this->out('Migrating Notifier Tables...');
        $this->execute('call cake migrations migrate -p Notifier');
        $this->out('<info>Migrating Notifier Tables completed!</info>');
        $this->hr();

        $this->out('Migrating Settings Tables...');
        $this->execute('call cake migrations migrate -p Settings');
        $this->out('<info>Migrating Settings Tables completed!</info>');
        $this->hr();

        $this->out('Generating a new administrator...');
        $this->dispatchShell('admin');
    }

    protected function execute($command)
    {
        return exec($command);
    }
}
