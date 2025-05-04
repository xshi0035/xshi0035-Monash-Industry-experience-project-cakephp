<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$this->layout = 'manager_view';
$this->assign('title', "Edit Category");
?>
<?= $this->Html->link(
    '<i class="fa fa-chevron-left mr-1" aria-hidden="true"></i> Back',
    'javascript:history.back()',
    ['escape' => false, 'class' => 'btn btn-link']
) ?>
<h3><?= __('Edit Category') ?></h3>
<hr>
<div class="row">
    <div class="col-sm-4">
        <?= $this->Form->create($category) ?>
        <?php
        echo $this->Form->control('name', [
            'class' => 'form-group form-control',
            'label' => 'Name*',
            'required' => true,
            'placeholder' => 'Enter category name',
            'pattern' => '[a-zA-Z\s-]+',
            'title' => 'Category name should only contain letters and spaces.'
        ]);
        ?>
    </div>
</div>
<?= $this->Html->link(__('Cancel'), 'javascript:history.back()', ['class' => 'btn btn-secondary']) ?>
<?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>

<?= $this->Html->script('/vendor/jquery/jquery.min.js') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea');

        function adjustHeight() {
            textarea.style.height = 'auto'; // Reset the height
            textarea.style.height = `${textarea.scrollHeight}px`; // Set height based on content
        }

        // Adjust height on page load if the textarea has prefilled content
        adjustHeight();
    });
</script>
