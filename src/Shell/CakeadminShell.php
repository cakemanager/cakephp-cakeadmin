<?php
namespace Bakkerij\CakeAdmin\Shell;

use Cake\Console\Shell;

/**
 * Cakeadmin shell command.
 */
class CakeadminShell extends Shell
{

    /**
     * Tasks
     *
     * @var array
     */
    public $tasks = [
        'Bakkerij/CakeAdmin.Init',
        'Bakkerij/CakeAdmin.Admin',
    ];

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->addSubcommand('init', [
            'help' => 'Initialize CakeAdmin. Will create a base CakeAdmin.php file',
            'parser' => $this->Admin->getOptionParser(),
        ]);
        $parser->addSubcommand('admin', [
            'help' => 'Create CakeAdmin Administrator',
            'parser' => $this->Admin->getOptionParser(),
        ]);

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
        $this->out($this->OptionParser->help());
    }
}
