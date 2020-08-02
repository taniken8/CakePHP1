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
            <?= $this->Html->link(__('Edit Bidcontact'), ['action' => 'edit', $bidcontact->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bidcontact'), ['action' => 'delete', $bidcontact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bidcontact->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bidcontacts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bidcontact'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bidcontacts view content">
            <h3><?= h($bidcontact->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td>
                        <?php if ($bidcontact->has('user')) {
                            echo $this->Html->link($bidcontact->user->id, ['controller' => 'Users', 'action' => 'view', $bidcontact->user->id]);
                        } else {
                            '';
                        } ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Zip') ?></th>
                    <td><?= h($bidcontact->zip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($bidcontact->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number') ?></th>
                    <td><?= h($bidcontact->phone_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bidcontact->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bidinfo Id') ?></th>
                    <td><?= $this->Number->format($bidcontact->bidinfo_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($bidcontact->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Send') ?></th>
                    <td><?= $bidcontact->send ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Receipt') ?></th>
                    <td><?= $bidcontact->receipt ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
