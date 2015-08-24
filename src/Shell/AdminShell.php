<?php
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
     * @return bool|int Success or error code.
     */
    public function main() {
        $email = $this->in('E-mailaddress:');

        $password = $this->in('Password: [WILL BE VISIBLE]');

        $this->loadModel('CakeAdmin.Administrators');

        $entity = $this->Administrators->newEntity([
            'email' => $email,
            'password' => $password
        ]);

        if($this->Administrators->save($entity)) {
            $this->out('<info>Administrator has been saved</info>');
        } else {
            $this->out('<warning>Administrator could not be saved</warning>');
        }
    }

}
