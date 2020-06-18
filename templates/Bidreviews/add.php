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
            <?= $this->Html->link(__('List Bidreviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bidreviews form content">
            <?= $this->Form->create($bidreview) ?>
            <fieldset>
                <legend><?= __('Add Bidreview') ?></legend>
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
