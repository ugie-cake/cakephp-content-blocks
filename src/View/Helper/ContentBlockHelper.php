<?php
namespace ContentBlocks\View\Helper;

use Cake\Datasource\FactoryLocator;
use Cake\Routing\Router;
use Cake\View\Helper;
use ContentBlocks\Model\Entity\ContentBlock;
use ContentBlocks\Model\Table\ContentBlocksTable;

/**
 * @property Helper\HtmlHelper Html
 */
class ContentBlockHelper extends Helper
{

    public array $helpers = ['Html'];

    /**
     * @var ContentBlocksTable
     */
    private $ContentBlocks;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->ContentBlocks = FactoryLocator::get('Table')->get('ContentBlocks.ContentBlocks');
    }

    private function findOrfail(string $slug, string $expectedType): ContentBlock {
        $found = $this->ContentBlocks->find()->where(['slug' => $slug])->toArray();
        if (!$found) {
            throw new \InvalidArgumentException("Content block '" . $slug . "' not found.");
        }

        $block = $found[0];

        if ($expectedType && $block->type !== $expectedType) {
            throw new \InvalidArgumentException("Content block '" . $slug . "' type is '" . $block->type . "', expected it to be an '" . $expectedType . "'.");
        }

        return $block;
    }

    /**
     * Calls {@link HtmlHelper::image()} where the path to the image is {@link ContentBlock::$value}.
     *
     * @param string $slug The content block to show.
     * @param array $options These are passed to the {@link HtmlHelper::image()} function.
     * @return mixed
     */
    public function image(string $slug, array $options = []): ?string
    {
        $path = $this->imagePath($slug);

        return $path ? $this->Html->image($path, $options) : null;
    }

    /**
     * Returns the path to a particular image stored as a content block.
     *
     * This is for use in things such as CSS background images.
     *
     * @param string $slug
     * @return string
     */
    public function imagePath(string $slug): ?string {
        return $this->findOrfail($slug, 'image')->value;
    }

    /**
     * Returns the path to a particular image stored as a content block.
     *
     * Consider using {@link ContentBlockHelper::image()} instead to render a proper <img /> tag.
     * @param string $slug
     * @return string
     */
    public function html(string $slug): string {
        return $this->findOrfail($slug, 'html')->value;
    }

    /**
     * Returns a plain text string stored as a content block.
     *
     * **Note:** This does not escape the HTML output, because that is done when saving to the database via the Controller.
     *
     * @param string $slug
     * @return string
     */
    public function text(string $slug): string {
        return $this->findOrfail($slug, 'text')->value;
    }
}
