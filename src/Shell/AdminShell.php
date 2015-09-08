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
