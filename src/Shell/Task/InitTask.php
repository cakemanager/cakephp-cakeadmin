<?php
namespace Bakkerij\CakeAdmin\Shell\Task;

use Cake\Console\Shell;
use Cake\Core\Plugin;

/**
 * Init shell task.
 */
class InitTask extends Shell
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $file = Plugin::configPath('Bakkerij/CakeAdmin') . 'init' . DS . 'CakeAdmin.default.php';

        $this->createFile(APP . DS . 'CakeAdmin.php', file_get_contents($file));
    }
}
