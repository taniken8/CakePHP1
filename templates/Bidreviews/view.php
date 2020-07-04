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
            <?= $this->Html->link(__('Edit Bidreview'), ['action' => 'edit', $bidreview->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bidreview'), ['action' => 'delete', $bidreview->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidreview->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bidreviews'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bidreview'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bidreviews view content">
            <h3><?= h($bidreview->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $bidreview->has('user') ? $this->Html->link($bidreview->user->id, ['controller' => 'Users', 'action' => 'view', $bidreview->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Comment') ?></th>
                    <td><?= h($bidreview->comment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bidreview->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Review User Id') ?></th>
                    <td><?= $this->Number->format($bidreview->review_user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rate') ?></th>
                    <td><?= $this->Number->format($bidreview->rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($bidreview->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
