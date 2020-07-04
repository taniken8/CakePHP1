<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidreview $bidreview
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bidreview->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bidreview->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bidreviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bidreviews form content">
            <?= $this->Form->create($bidreview) ?>
            <fieldset>
                <legend><?= __('Edit Bidreview') ?></legend>
                <?php
                    echo $this->Form->control('review_user_id');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('rate');
                    echo $this->Form->control('comment');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
