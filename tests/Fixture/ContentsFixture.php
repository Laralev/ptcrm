<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContentsFixture
 */
class ContentsFixture extends TestFixture
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
                'user_id' => 1,
                'language_id' => 1,
                'content_title' => 'Lorem ipsum dolor sit amet',
                'content_desc' => 'Lorem ipsum dolor sit amet',
                'features_ids' => 'Lorem ipsum dolor sit amet',
                'content_search_pool' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'seo_keywords' => 'Lorem ipsum dolor sit amet',
                'stat_created' => '2023-03-25 12:36:54',
                'stat_updated' => '2023-03-25 12:36:54',
                'stat_views' => 1,
                'stat_shares' => 1,
                'rec_state' => 1,
            ],
        ];
        parent::init();
    }
}
