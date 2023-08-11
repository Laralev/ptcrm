<?php
$fields = ['id', 'client_id', 'client_name',  'spec_name', 'spec_value', 'stat_configs', 'rec_state'];
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

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


