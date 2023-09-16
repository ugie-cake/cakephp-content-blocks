<?php
# File: config/Seeds/TextBlockSeed.php
class TextBlockSeed extends \Migrations\AbstractSeed
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
