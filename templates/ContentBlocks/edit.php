<?php
/**
 * @var \App\View\AppView $this
 * @var \ContentBlocks\Model\Entity\ContentBlock $contentBlock
 * @var string[] $content_types
 */

$this->assign('title', 'Edit Content Block - Content Blocks');

$this->Html->script('ContentBlocks.ckeditor/ckeditor', ['block' => true]);

$this->Html->css('ContentBlocks.content-blocks', ['block' => true]);
?>

<style>
    .ck-editor__editable_inline {
        min-height: 25rem; /* CKEditor field minimal height */
    }
</style>

<div class="row">
    <div class="column-responsive">

        <div class="contentBlocks form content">

            <h3 class="content-blocks--form-heading"><?= $contentBlock->display_name ?></h3>

            <div class="content-blocks--form-description">
                <?= $contentBlock->description ?>
            </div>

            <?= $this->Form->create($contentBlock, ['type' => 'file']) ?>

            <?php
            if ($contentBlock->content_type === 'text') {
                echo $this->Form->control('content_value', [
                    'type' => 'text',
                    'value' => html_entity_decode($contentBlock->content_value),
                    'label' => false,
                ]);
            } else if ($contentBlock->content_type === 'html') {
                echo $this->Form->control('content_value', [
                    'type' => 'textarea',
                    'label' => false,
                    'id' => 'content-value-input'
                ]);

                ?>
                <script>
                    CKSource.Editor.create(
                        document.getElementById('content-value-input'),
                        {
                            toolbar: [
                                "heading", "|",
                                "bold", "italic", "underline", "|",
                                "bulletedList", "numberedList", "|",
                                "alignment", "blockQuote", "|",
                                "indent", "outdent", "|",
                                "link", "|",
                                "insertTable", "imageInsert", "mediaEmbed", "horizontalLine", "|",
                                "removeFormat", "|",
                                "sourceEditing", "|",
                                "undo", "redo",
                            ],
                            simpleUpload: {
                                uploadUrl: <?= json_encode($this->Url->build(['action' => 'upload'])) ?>,
                                headers: {
                                   'X-CSRF-TOKEN': <?= json_encode($this->request->getAttribute('csrfToken')) ?>,
                                }
                            }
                        }
                    ).then(editor => {
                       console.log(Array.from( editor.ui.componentFactory.names() ));
                    });
                </script>
                <?php
            } else if ($contentBlock->content_type === 'image') {

                if ($contentBlock->content_value) {
                    echo $this->Html->image($contentBlock->content_value, ['class' => 'content-blocks--image-preview']);
                }

                echo $this->Form->control('content_value', [
                    'type' => 'file',
                    'accept' => 'image/*',
                    'label' => false,
                ]);
            }

            ?>
            <div class="content-blocks--form-actions">
                <?= $this->Form->button(__('Save'), ['class' => 'button btn']) ?>
                <?= $this->Html->link('Cancel', ['action' => 'index']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

