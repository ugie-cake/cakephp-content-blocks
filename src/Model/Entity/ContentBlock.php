<?php
declare(strict_types=1);

namespace ContentBlocks\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContentBlock Entity
 *
 * @property string $id
 * @property string $parent
 * @property string $slug
 * @property string $type
 * @property string $value
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
    protected array $_accessible = [
        'value' => true,
    ];

    /**
     * Generate display field for ContentBlock entity
     * @return string Display field
     */
    protected function _getDisplayField() {
        return $this->parent . '/' . $this->slug . ' (' . $this->type . ')';
    }
}
