<?php
namespace ContentBlocks\View\Helper;

use Cake\Datasource\FactoryLocator;
use Cake\View\Helper;
use ContentBlocks\Model\Entity\ContentBlock;
use ContentBlocks\Model\Table\ContentBlocksTable;

class ContentBlockHelper extends Helper
{

    public $helpers = ['Html'];

    /**
     * @var ContentBlocksTable
     */
    private $ContentBlocks;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->ContentBlocks = FactoryLocator::get('Table')->get('ContentBlocks.ContentBlocks');
    }

    private function findOrfail(string $key, string $expectedType): ContentBlock {
        $found = $this->ContentBlocks->find()->where(['hint' => $key])->toArray();
        if (!$found) {
            throw new \InvalidArgumentException("Content block '" . $key . "' not found.");
        }

        $block = $found[0];

        if ($expectedType && $block->content_type !== $expectedType) {
            throw new \InvalidArgumentException("Content block '" . $key . "' type is '" . $block->content_type . "', expeted it to be an '" . $expectedType . "'.");
        }

        return $block;
    }

    /**
     * Calls {@link HtmlHelper::image()} where the path to the image is {@link ContentBlock::$content_value}.
     *
     * @param string $key The content block to show.
     * @param array $options These are passed to the {@link HtmlHelper::image()} function.
     * @return mixed
     */
    public function image(string $key, array $options = []): string
    {
        $block = $this->findOrfail($key, 'image');

        return $this->Html->image($block->content_value, $options);
    }

    /**
     * Returns the path to a particular image stored as a content block.
     *
     * Consider using {@link ContentBlockHelper::image()} instead to render a proper <img /> tag.
     * @param string $key
     * @return string
     */
    public function imagePath(string $key): string {
        return $this->findOrfail($key, 'image')->content_value;
    }

    /**
     * Returns the path to a particular image stored as a content block.
     *
     * Consider using {@link ContentBlockHelper::image()} instead to render a proper <img /> tag.
     * @param string $key
     * @return string
     */
    public function html(string $key): string {
        return $this->findOrfail($key, 'html')->content_value;
    }

    /**
     * Returns a plain text string stored as a content block.
     *
     * **Note:** This does not escape the HTML output, because that is done when saving to the database via the Controller.
     *
     * @param string $key
     * @return string
     */
    public function text(string $key): string {
        return $this->findOrfail($key, 'text')->content_value;
    }
}
