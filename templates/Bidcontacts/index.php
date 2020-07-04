<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bidcontact[]|\Cake\Collection\CollectionInterface $bidcontacts
 */
?>
<div class="bidcontacts index content">
    <?= $this->Html->link(__('New Bidcontact'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bidcontacts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('bidinfo_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('zip') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('phone_number') ?></th>
                    <th><?= $this->Paginator->sort('send') ?></th>
                    <th><?= $this->Paginator->sort('receipt') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bidcontacts as $bidcontact): ?>
                <tr>
                    <td><?= $this->Number->format($bidcontact->id) ?></td>
                    <td><?= $this->Number->format($bidcontact->bidinfo_id) ?></td>
                    <td><?= $bidcontact->has('user') ? $this->Html->link($bidcontact->user->id, ['controller' => 'Users', 'action' => 'view', $bidcontact->user->id]) : '' ?></td>
                    <td><?= h($bidcontact->zip) ?></td>
                    <td><?= h($bidcontact->address) ?></td>
                    <td><?= h($bidcontact->phone_number) ?></td>
                    <td><?= h($bidcontact->send) ?></td>
                    <td><?= h($bidcontact->receipt) ?></td>
                    <td><?= h($bidcontact->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bidcontact->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bidcontact->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bidcontact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidcontact->id)]) ?>
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
