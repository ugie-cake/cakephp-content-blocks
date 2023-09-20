<?php
# File: config/Seeds/ImageBlockSeed.php
class ImageBlockSeed extends \Migrations\AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'global',
                'slug' => 'logo',
                'label' => 'Logo',
                'description' => 'Shown on the home page, and also in the top left of each other page.',
                'type' => 'image',
            ],
        ];

        $this->table('content_blocks')->insert($data)->save();
    }
}
