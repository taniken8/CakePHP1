<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidcontact $bidcontact
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bidcontacts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bidcontacts form content">
            <?= $this->Form->create($bidcontact) ?>
            <fieldset>
                <legend><?= __('Add Bidcontact') ?></legend>
                <?php
                    echo $this->Form->control('bidinfo_id');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('zip');
                    echo $this->Form->control('address');
                    echo $this->Form->control('phone_number');
                    echo $this->Form->control('send');
                    echo $this->Form->control('receipt');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
