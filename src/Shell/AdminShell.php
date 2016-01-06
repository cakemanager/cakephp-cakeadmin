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

/**
 * Admin shell command.
 */
class AdminShell extends Shell
{

    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $email = $this->in('E-mailaddress:');

        $password = $this->in('Password: [WILL BE VISIBLE]');

        $this->loadModel('CakeAdmin.Administrators');

        $entity = $this->Administrators->newEntity([
            'email' => $email,
            'password' => $password
        ]);

        if ($this->Administrators->save($entity)) {
            $this->out('<info>Administrator has been saved</info>');
        } else {
            $this->out('<error>Administrator could not be saved. Run $ bin/cake admin to create an admin.</error>');
            $this->hr();
            foreach ($entity->errors() as $field => $errors) {
                foreach ($errors as $error) {
                    $this->out('<warning>For field `' . $field . '`: ' . $error . ' </warning>');
                }
            }
            $this->hr();
        }
    }
}
