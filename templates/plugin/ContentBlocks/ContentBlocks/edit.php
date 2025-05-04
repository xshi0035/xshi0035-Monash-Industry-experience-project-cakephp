<?php
/**
 * @var \App\View\AppView $this
 * @var \ContentBlocks\Model\Entity\ContentBlock $contentBlock
 */

$this->assign('title', 'Edit Content Block');

$this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', ['block' => true]);
$this->Html->css('ContentBlocks.content-blocks.css', ['block' => true]); // Custom styles if any
$this->Html->script('https://code.jquery.com/jquery-3.5.1.slim.min.js', ['block' => true]);
$this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js', ['block' => true]);
$this->Html->script('ContentBlocks.ckeditor/ckeditor.js', ['block' => true]);

$this->layout = 'manager_view';

// Redirect non-authorized users
$roleId = $this->request->getSession()->read('Auth.role_id');
if ($roleId != 1 && $roleId != 2) {
    $redirectUrl = $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'indexById']);
    return $this->redirect($redirectUrl);
}
?>

<style>
    .ck-editor__editable_inline {
        min-height: 300px; /* Adjusted for better visibility */
    }
    .content-block-form {
        max-width: 800px;
        margin: 0 auto;
    }
</style>

<div class="container content-block-form mt-5">
    <h2 class="mb-4 text-center"><?= h($contentBlock->label) ?></h2>
    <p class="text-muted text-center"><?= h($contentBlock->description) ?></p>

    <?= $this->Form->create($contentBlock, ['type' => 'file']) ?>

    <?php
    if ($contentBlock->type === 'text') {
        // Simple text input
        echo $this->Form->control('value', [
            'type' => 'text',
            'label' => 'Content',
            'class' => 'form-control',
            'value' => html_entity_decode($contentBlock->value),
            'placeholder' => 'Enter the content here...',
        ]);
    } elseif ($contentBlock->type === 'html') {
        // WYSIWYG editor for HTML content
        echo $this->Form->control('value', [
            'type' => 'textarea',
            'label' => 'Content',
            'class' => 'form-control',
            'id' => 'content-value-input',
            'placeholder' => 'Enter the content here...',
        ]);
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                ClassicEditor.create(document.querySelector('#content-value-input'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', '|',
                        'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ],
                    simpleUpload: {
                        uploadUrl: <?= json_encode($this->Url->build(['action' => 'upload'])) ?>,
                        headers: {
                            'X-CSRF-TOKEN': <?= json_encode($this->request->getAttribute('csrfToken')) ?>,
                        }
                    }
                }).catch(error => {
                    console.error(error);
                });
            });
        </script>
        <?php
    } elseif ($contentBlock->type === 'image') {
        // Image upload field
        if ($contentBlock->value) {
            echo '<div class="mb-3 text-center">';
            echo $this->Html->image($contentBlock->value, ['class' => 'img-thumbnail', 'style' => 'max-width: 300px;']);
            echo '</div>';
        }
        echo $this->Form->control('value', [
            'type' => 'file',
            'label' => 'Upload Image',
            'accept' => 'image/*',
            'class' => 'form-control-file',
        ]);
    }
    ?>

    <div class="form-group mt-4 text-center">
        <?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-success']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary ml-2']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
