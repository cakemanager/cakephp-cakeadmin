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
namespace CakeAdmin\Shell\Task;

use Cake\Console\Shell;

class NewAdminTask extends Shell
{
    public function main()
    {
        $email = $this->in('E-mailaddress:');

        $password = $this->in('Password: [WILL BE VISIBLE]');

        $this->loadModel('CakeAdmin.Administrators');

        $entity = $this->Administrators->newEntity([
            'email' => $email,
            'password' => $password
        ]);

        if($this->Administrators->save($entity)) {
            $this->out('Administrator has been saved');
        } else {
            $this->out('Administrator could not be saved');
        }
    }
}