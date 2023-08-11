<?php
$fields = ['id', 'office_name', 'office_desc', 'office_photos', 'office_coverage', 'stat_created', 'rec_state'];
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
                        <?php foreach($fields as $field){
                                if(is_object($rec->$field)){ continue; }?>
                            <tr>
                                <th><?= __($field) ?></th>
                                <td><?= $this->Do->DtSetter($rec->$field, $field) ?></td>
                            </tr>
                            <?php if(is_object($rec->$field)){?>
                                <tr>
                                    <th><?= __($field) ?></th>
                                    <td></td>
                                </tr>
                                <?php foreach($rec->$field as $field2){?>
                                    <tr>
                                        <th><?= __($field2) ?></th>
                                        <td><?= $this->Do->DtSetter($rec->$field->field2, $field2) ?></td>
                                    </tr>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


