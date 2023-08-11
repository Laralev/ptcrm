<?php
$fields = ['id', 'user_id', 'log_url', 'log_changes', 'stat_created', 'rec_state'];
$ctrl = $this->request->getParam('controller');
$prefix = $rec->log_url[5] == 'Properties' ? 'PROP' : 'PROJ';
$actionsName = $this->Do->get('actionsName');
// $rec->log_changes = !is_array($rec->log_changes) ? [] : $rec->log_changes;
// debug($rec->toArray()); 
// die();
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?=__('view_'.$ctrl.'_rec')?></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    
                    <div class="view_page">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th><?= __('id') ?></th>
                                <td><?= $rec->id ?></td>
                            </tr>
                            <tr>
                                <th><?= __('user_id') ?></th>
                                <td><?= $rec->user->user_fullname ?></td>
                            </tr>
                            <tr>
                                <th><?= __('log_url') ?></th>
                                <td> 
                                    <b><?=__('section')?>:</b> <?=__($rec->log_url[5])?> / 
                                    <b><?=__('action')?>:</b> 
                                    <span  class="badge badge-{{actionsClr['<?=$rec->log_url[6]?>']}}"><?=$actionsName[$rec->log_url[6]]?></span> / 
                                    <b><?=__('id')?>:</b> <?= @$rec->log_url[7] ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?= __('log_changes') ?></th>
                                <td>
                                    <?php if(count($rec->log_changes) > 1){?>
                                        <div class='row hideMobSm boldText'>
                                            <div class='col-sm-4'><?=__('item')?></div>
                                            <div class='col-sm-4'><?=__('before')?></div>
                                            <div class='col-sm-4'><?=__('after')?></div>
                                        </div>
                                        <div class='row'>
                                        <?php foreach($rec->log_changes[0] as $key=>$itm){?>
                                            <div class='col-sm-4'><b><?=__($key)?></b></div>
                                            <div class='col-sm-4 col-6 grayText'><?=$itm?></div>
                                            <div class='col-sm-4 col-6'><?=$rec->log_changes[1][$key]?></div>
                                        <?php }?>
                                        </div>
                                    <?php }else{?>
                                        <div class='row hideMobSm boldText'>
                                            <div class='col-sm-6'><?=__('item')?></div>
                                            <div class='col-sm-6'><?=__('details')?></div>
                                        </div>
                                        <div class='row'>
                                        <?php foreach($rec->log_changes[0] as $key=>$itm){?>
                                            <div class='col-sm-6'><b><?=__($key)?></b></div>
                                            <div class='col-sm-6'><?=$this->Do->DtSetter($itm, $key, $prefix)?></div>
                                        <?php }?>
                                        </div>
                                    <?php }?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


