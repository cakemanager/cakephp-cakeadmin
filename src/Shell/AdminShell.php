<?php
namespace CakeAdmin\Shell;

use Cake\Console\Shell;

/**
 * Admin shell command.
 */
class AdminShell extends Shell
{

    public $tasks = ['CakeAdmin.NewAdmin'];

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() {
    }

    /**
     * getOptionParser method.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->addSubcommand('newAdmin', [
            'help' => 'Create a new administrator.'
        ]);

        return $parser;
    }
}
