<?php
declare(strict_types=1);

use Migrations\BaseSeed;

# File: config/Seeds/TextBlockSeed.php
class TextBlockSeed extends BaseSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'home',
                'slug' => 'website-title',
                'label' => 'Website Title',
                'description' => 'Heading shown on the main page, and also in the browser tab.',
                'type' => 'text',
                'value' => 'CakePHP Content Blocks Plugin',
            ],
        ];

        $this->table('content_blocks')->insert($data)->save();
    }
}
