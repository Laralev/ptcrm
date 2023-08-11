<?php
$fields = ['id', 'user_fullname', 'email', 'user_role', 'user_token', 'stat_lastlogin', 'stat_created', 'stat_logins', 'stat_ip', 'rec_state', 'office'];
$ctrl = $this->request->getParam('controller');
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

                        <?php foreach($fields as $field){ if(!is_object($rec->$field) ){ ?>
                            <tr>
                                <th><?= __($field) ?></th>
                                <td><?= $this->Do->DtSetter($rec->$field, $field) ?></td>
                            </tr>
                        <?php }}?>

                        <?php if( !empty($rec->office) ){?>
                        <tr>
                            <th><?= __('office') ?></th>
                            <td><?= $this->Html->link($rec->office->office_name, 
                                ['controller'=>'Offices', 'action'=>'view', $rec->office->id],
                                ['class'=>'small-btn'])?></td>
                        </tr>
                        <?php }?>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


