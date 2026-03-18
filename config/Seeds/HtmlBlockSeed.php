<?php
declare(strict_types=1);

use Migrations\BaseSeed;

# File: config/Seeds/HtmlBlockSeed.php
class HtmlBlockSeed extends BaseSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'about-us',
                'slug' => 'about-us-content',
                'label' => 'About Us - Main Content',
                'description' => 'Main block of code shown on the About Us page.',
                'type' => 'html',
                'value' => '
                    <h2>Our Story</h2>
                    <p>We are a small business, established in 2023 who sell candles to sick children.</p>
                ',
            ],
        ];

        $this->table('content_blocks')->insert($data)->save();
    }
}
