<?php
namespace Bakkerij\CakeAdmin\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Administrator Entity
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $active
 * @property string $request_key
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Administrator extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
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
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
