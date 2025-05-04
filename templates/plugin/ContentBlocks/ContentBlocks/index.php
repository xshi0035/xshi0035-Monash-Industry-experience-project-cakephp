<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\ContentBlocks\Model\Entity\ContentBlock> $contentBlocksGrouped
 */

$this->assign('title', 'Website Customisation');

// Include Bootstrap CSS and custom styles
$this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', ['block' => true]);
$this->Html->css('ContentBlocks.content-blocks', ['block' => true]);
$this->Html->css('custom_styles.css', ['block' => true]);

$this->layout = 'manager_view';

$slugify = function($text) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($text));
};

// Redirect non-authorized users
$roleId = $this->request->getSession()->read('Auth.role_id');
if ($roleId != 1 && $roleId != 2) {
    $redirectUrl = $this->Url->build(['plugin' => null, 'controller' => 'Bookings', 'action' => 'indexById']);
    return $this->redirect($redirectUrl);
}
?>

<div class="contentBlocks index content">

    <?php
    /*
    // TODO: Think of a way to allow this for developers, but not for the actual website. Adding a content block doesn't
    //       mean anything for end users - it needs to be hard coded into a template somewhere to make sense. Perhaps
    //       it can just be guarded behind a DEBUG flag with an appropriate confirm() dialog warning that it needs to
    //       be used in a template after being added...
    echo $this->Html->link(__('New Content Block'), ['action' => 'add'], ['class' => 'button button-outline float-right'])
    */
    ?>
    
    <h3 class="mb-4"><?= __('Website Customisation') ?></h3>

    <!-- Quick Links Navigation -->
    <nav class="mb-4">
        <ul class="nav nav-pills">
            <?php foreach (array_keys($contentBlocksGrouped) as $parent) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="#<?= $slugify($parent) ?>"><?= $parent ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <!-- Content Blocks -->
    <?php foreach ($contentBlocksGrouped as $parent => $contentBlocks) { ?>
        <h4 id="<?= $slugify($parent) ?>" class="mt-5"><?= $parent ?></h4>
        <div class="row">
            <?php foreach ($contentBlocks as $contentBlock) { ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= h($contentBlock->label) ?></h5>
                            <p class="card-text"><?= h($contentBlock->description) ?></p>
                            <div class="mt-auto">
                                <?= $this->Html->link(
                                    __('Edit'),
                                    ['action' => 'edit', $contentBlock->id],
                                    ['class' => 'btn btn-primary']
                                ) ?>
                                <?php if (!empty($contentBlock->previous_value)) : ?>
                                    <?= $this->Form->postLink(
                                        __('Restore'),
                                        ['action' => 'restore', $contentBlock->id],
                                        [
                                            'confirm' => __(
                                                "Are you sure you want to restore the previous version for this item?\n{0}/{1}\nNote: You cannot cancel this action!",
                                                $contentBlock->parent,
                                                $contentBlock->slug
                                            ),
                                            'class' => 'btn btn-warning'
                                        ]
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<!-- Include Bootstrap JS -->
<?= $this->Html->script('https://code.jquery.com/jquery-3.5.1.slim.min.js') ?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js') ?>
