<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SpecsFixture
 */
class SpecsFixture extends TestFixture
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
                'language_id' => 1,
                'content_id' => 1,
                'spec_name' => 'Lorem ipsum dolor sit amet',
                'spec_value' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
