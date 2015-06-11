<?php
namespace CakeAdmin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Administrator Entity.
 */
class Administrator extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'new_password' => true,
        'confirm_password' => true,
        'cakeadmin' => true,
    ];

    /**
     * _setPassword
     *
     * Setter for the password column.
     * This method will hash the password with the DefaultPasswordHasher class.
     *
     * @param string $password The clean password.
     * @return string
     */
    protected function _setPassword($password)
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }

    /**
     * Fields that should be hidden.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

}
