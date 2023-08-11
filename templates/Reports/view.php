<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report $report
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Report'), ['action' => 'edit', $report->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Report'), ['action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete # {0}?', $report->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reports'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Report'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reports view content">
            <h3><?= h($report->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tar Tbl') ?></th>
                    <td><?= h($report->tar_tbl) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($report->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tar Id') ?></th>
                    <td><?= $this->Number->format($report->tar_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($report->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Id') ?></th>
                    <td><?= $this->Number->format($report->status_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rec State') ?></th>
                    <td><?= $this->Number->format($report->rec_state) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stat Created') ?></th>
                    <td><?= h($report->stat_created) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Report Text') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($report->report_text)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
