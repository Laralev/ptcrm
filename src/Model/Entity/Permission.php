<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity
 *
 * @property int $id
 * @property string $permission_role
 * @property string $permission_module
 * @property int $permission_c
 * @property int $permission_r
 * @property int $permission_u
 * @property int $permission_d
 */
class Permission extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'permission_role' => true,
        'permission_module' => true,
        'permission_c' => true,
        'permission_r' => true,
        'permission_u' => true,
        'permission_d' => true,
    ];
}
