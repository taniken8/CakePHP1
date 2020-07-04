<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidreview[]|\Cake\Collection\CollectionInterface $bidreviews
 */
?>
<div class="bidreviews index content">
    <?= $this->Html->link(__('New Bidreview'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bidreviews') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('review_user_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('rate') ?></th>
                    <th><?= $this->Paginator->sort('comment') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bidreviews as $bidreview): ?>
                <tr>
                    <td><?= $this->Number->format($bidreview->id) ?></td>
                    <td><?= $this->Number->format($bidreview->review_user_id) ?></td>
                    <td><?= $bidreview->has('user') ? $this->Html->link($bidreview->user->id, ['controller' => 'Users', 'action' => 'view', $bidreview->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($bidreview->rate) ?></td>
                    <td><?= h($bidreview->comment) ?></td>
                    <td><?= h($bidreview->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bidreview->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bidreview->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bidreview->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidreview->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
