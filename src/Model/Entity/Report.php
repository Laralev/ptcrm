<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Report Entity
 *
 * @property int $id
 * @property int $tar_id
 * @property string $tar_tbl
 * @property int $user_id
 * @property int $status_id
 * @property string $report_text
 * @property \Cake\I18n\FrozenTime $stat_created
 * @property int $rec_state
 */
class Report extends Entity
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
        'tar_id' => true,
        'tar_tbl' => true,
        'user_id' => true,
        'status_id' => true,
        'report_text' => true,
        'stat_created' => true,
        'rec_state' => true,
    ];
}
