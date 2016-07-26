<?php
namespace Bakkerij\CakeAdmin\Shell\Task;

use Cake\Console\Shell;

/**
 * Admin shell task.
 */
class AdminTask extends Shell
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
        $email = $this->in('E-mail:');

        $password = 'cakeadmin';
        $this->out('Password will be `cakeadmin`. You can change this later');

        $name = $this->in('Name:');

        $this->loadModel('Bakkerij/CakeAdmin.Administrators');

        $entity = $this->Administrators->newEntity([
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'active' => 1
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
