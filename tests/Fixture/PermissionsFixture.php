<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PermissionsFixture
 */
class PermissionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'permission_role' => 'Lorem ipsum dolor sit amet',
                'permission_module' => 'Lorem ipsum dolor sit amet',
                'permission_c' => 1,
                'permission_r' => 1,
                'permission_u' => 1,
                'permission_d' => 1,
            ],
        ];
        parent::init();
    }
}
