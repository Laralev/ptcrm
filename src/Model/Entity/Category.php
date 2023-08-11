<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int $language_id
 * @property int $parent_id
 * @property string $category_name
 * @property string|null $category_configs
 * @property int|null $category_priority
 * @property int|null $rec_state
 *
 * @property \App\Model\Entity\Category $parent_category
 * @property \App\Model\Entity\Category[] $child_categories
 */
class Category extends Entity
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
        'language_id' => true,
        'parent_id' => true,
        'category_name' => true,
        'category_configs' => [
            'icon' => true,
            'isProtected' => true,
        ],
        'category_priority' => true,
        'rec_state' => true,
        'parent_category' => true,
        'child_categories' => true,
    ];
}
