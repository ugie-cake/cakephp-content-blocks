<?php
declare(strict_types=1);

namespace ContentBlocks\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentBlock Entity
 *
 * @property string $id
 * @property string $parent
 * @property string $hint
 * @property string $content_type
 * @property string $content_value
 * @property string|null $previous_value
 * @property \Cake\I18n\FrozenTime $modified
 */
class ContentBlock extends Entity
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
        'parent' => true,
        'hint' => true,
        'content_type' => true,
        'content_value' => true,
        'previous_value' => true,
        'modified' => true,
    ];

    /**
     * Generate display field for ContentBlock entity
     * @return string Display field
     */
    protected function _getDisplayField() {
        return $this->parent . '/' . $this->hint . ' (' . $this->content_type . ')';
    }
}
