<!-- addEditReport_mdl modal -->
<div class="modal fade" id="addEditReport_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal header and title -->
            <!-- ... (existing code) ... -->

            <div class="modal-body">
                <button type="button" id="report_btn" class="hideIt" ng-click="
                    doGet('/admin/reports/index?list=1', 'list', 'reports'); 
                    rec.report = {};
                    doClick('.close');"></button>

                    <form  class="row" id="report_form" ng-submit="
                            rec.report.tar_id = rec.client.id; 
                            rec.report.tar_tbl = '<?=$this->request->getParam('controller')?>'; 
                            doSave(rec.report, 'report', 'reports', '#report_btn', '#report_preloader');">

                            <!-- Existing form fields ... -->
                            <h2 class="col-12"><?=__('add_report')?></h2>
                            
                            <div class="col-md-6 col-6  form-group has-feedback">
                                    <label><?= __('status_id') ?></label>
                                    <div class="div">
                                        <?= $this->Form->text('status_id', [
                                            'type' => 'select',
                                            'options'=>$this->Do->lcl( $this->Do->get('statusID') ),
                                            'class' => 'form-control has-feedback-left',
                                            'ng-model' => 'rec.report.status_id',
                                        ]) ?>
                                        <span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
                                    </div>
                                </div>

                            <div class="col-12  form-group has-feedback">
                                <label set-required><?=__('report_text')?></label>
                                <div class="div">
                                    <?=$this->Form->control('report_text', [
                                        'class'=>'form-control has-feedback-left',
                                        'label'=>false,
                                        'type'=>'textarea',
                                        'ng-model'=>'rec.report.report_text',
                                        'placeholder'=>__('report_text'),
                                    ])?>
                                    <span class="fa fa-report form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-info" id="report_preloader"><span></span> 
                                <i class="fa fa-save"></i> <?=__('save')?></button>
                            </div>
                    </form>
                    

            </div>
        </div>
    </div>
</div>


