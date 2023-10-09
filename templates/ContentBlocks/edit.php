<?php
/**
 * @var \App\View\AppView $this
 * @var \ContentBlocks\Model\Entity\ContentBlock $contentBlock
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

            <h3 class="content-blocks--form-heading"><?= $contentBlock->label ?></h3>

            <div class="content-blocks--form-description">
                <?= $contentBlock->description ?>
            </div>

            <?= $this->Form->create($contentBlock, ['type' => 'file']) ?>

            <?php
            if ($contentBlock->type === 'text') {
                echo $this->Form->control('value', [
                    'type' => 'text',
                    'value' => html_entity_decode($contentBlock->value),
                    'label' => false,
                ]);
            } else if ($contentBlock->type === 'html') {
                echo $this->Form->control('value', [
                    'type' => 'textarea',
                    'label' => false,
                    'id' => 'content-value-input'
                ]);

                ?>
                <!-- Load CKEditor. -->
                <script>
                    /*
                    Create our CKEditor instance in a DOMContentLoaded event callback, to ensure
                    the library is available when we call `create()`.
                    Fixes https://github.com/ugie-cake/cakephp-content-blocks/issues/4.
                    */
                    document.addEventListener("DOMContentLoaded", (event) => {
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
                    });
                </script>
                <?php
            } else if ($contentBlock->type === 'image') {

                if ($contentBlock->value) {
                    echo $this->Html->image($contentBlock->value, ['class' => 'content-blocks--image-preview']);
                }

                echo $this->Form->control('value', [
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

