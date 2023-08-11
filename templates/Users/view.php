<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User Fullname') ?></th>
                    <td><?= h($user->user_fullname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Role') ?></th>
                    <td><?= h($user->user_role) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Token') ?></th>
                    <td><?= h($user->user_token) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stat Ip') ?></th>
                    <td><?= h($user->stat_ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stat Logins') ?></th>
                    <td><?= $this->Number->format($user->stat_logins) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rec State') ?></th>
                    <td><?= $this->Number->format($user->rec_state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stat Lastlogin') ?></th>
                    <td><?= h($user->stat_lastlogin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stat Created') ?></th>
                    <td><?= h($user->stat_created) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Messages') ?></h4>
                <?php if (!empty($user->messages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('School Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Message To') ?></th>
                            <th><?= __('Message Subject') ?></th>
                            <th><?= __('Message Text') ?></th>
                            <th><?= __('Message Priority') ?></th>
                            <th><?= __('Stat Created') ?></th>
                            <th><?= __('Rec State') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->messages as $messages) : ?>
                        <tr>
                            <td><?= h($messages->id) ?></td>
                            <td><?= h($messages->school_id) ?></td>
                            <td><?= h($messages->user_id) ?></td>
                            <td><?= h($messages->parent_id) ?></td>
                            <td><?= h($messages->message_to) ?></td>
                            <td><?= h($messages->message_subject) ?></td>
                            <td><?= h($messages->message_text) ?></td>
                            <td><?= h($messages->message_priority) ?></td>
                            <td><?= h($messages->stat_created) ?></td>
                            <td><?= h($messages->rec_state) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Messages', 'action' => 'view', $messages->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Messages', 'action' => 'edit', $messages->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Messages', 'action' => 'delete', $messages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messages->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
