       
                                <div ng-repeat="itm in rec.<?= ($this->request->getParam('controller') === 'Clients') ? 'client' : (($this->request->getParam('controller') === 'Sales') ? 'sales' : '')  ?>.reports">
                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('tar_id')?></div>
                                    <div class="col-md-9 notwrapped">{{ itm.tar_id }}</div>
                                </div>

                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('tar_tbl')?></div>
                                    <div class="col-md-9 notwrapped">{{ itm.tar_tbl }}</div>
                                </div>

                                
                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('user_id')?></div>
                                    <div class="col-md-9 notwrapped">{{ itm.user_id }}</div>
                                </div>

                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('status_id ')?></div>
                                    <div class="col-md-9 notwrapped">{{ itm.status_id }}</div>
                                </div>

                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('report_text')?></div>
                                    <div class="col-md-9 notwrapped">{{ itm.report_text }}</div>
                                </div>
                                
                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('stat_created')?></div>
                                    <div class="col-md-9 notwrapped">{{itm.stat_created}}</div>
                                </div>
                                
                                <div class="grid_row row">
                                    <div class="col-md-3 grid_header2"><?=__('rec_state')?></div>
                                    <div class="col-md-9 notwrapped" ng-bind-html="DtSetter( 'bool2', rec.report.rec_state )"></div>
                                </div>
                            </div>
                                

                                <div class="grid_row row" ng-repeat="itm in rec.report.sale_specs">
                                    <div class="col-md-3 grid_header2">{{itm.spec_name}}</div>
                                    <div class="col-md-9 notwrapped">{{itm.spec_value}}</div>
                                </div>

                            </div>
                        </div>



                        <button id="report_btn"
                            ng-click="doGet('/admin/<?= ($this->request->getParam('controller') === 'Clients') ? 'clients' : (($this->request->getParam('controller') === 'Sales') ? 'sales' : '') ?>?id='+rec.client.id, 'client', 'rec')">Call Back</button>
                        
                        
                        <form  class="row" id="report_form" ng-submit="
                            rec.report.tar_id = rec.<?= ($this->request->getParam('controller') === 'Clients') ? 'client' : (($this->request->getParam('controller') === 'Sales') ? 'sale' : '') ?>.id; 
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
                    
