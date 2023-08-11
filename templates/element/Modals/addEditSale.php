

<!-- addEditSale_mdl modal -->
<div class="modal fade" id="addEditSale_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal header and title -->
            <!-- ... (existing code) ... -->

            <div class="modal-body">
                <button type="button" id="sale_btn" class="hideIt" ng-click=
                "doGet('/admin/sales/index?list=1', 'list', 'sales');   rec.sales = {}; doClick('.close');"></button>

                <!-- Sale form -->
                <form class="row" id="sale_form" ng-submit="
                 doSave(rec.sales, 'sales', 'sales', '#sale_btn', 
                '#sale_preloader');">

                <div class="col-md-6 col-sm-6 form-group has-feedback">
                    <label set-required><?= __('client_id') ?></label>
                    <div class="div">
                        <!-- Client select input -->
                        <select class="form-control has-feedback-left"
                                ng-model="rec.sales.client_id"
                                ng-change="onClientSelectionChange()"
                                
                                >
                            <option value="">Select Client</option>
                            <option value="add_client">Add Client</option>
                            <option ng-repeat="(clientId, clientName) in DtSetter('clientsList', 'list')" value="{{clientId}}">{{clientName}}</option>
                        </select>
                        <span class="fa fa-sale form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 form-group has-feedback">
                    <label><?= __('segement_id') ?></label>
                    <div class="div">
                        <?= $this->Form->control('segement_id', [
                            'class' => 'form-control has-feedback-left',
                            'label' => false,
                            'type' => 'select', 
                            'options' => $optionsSegement,
                            'empty' => 'Select Segement_id', 
                            'ng-model' => 'rec.sales.segement_id',
                        ]) ?>
                        <span class="fa fa-sale form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>


                <div class="col-md-6 col-sm-6 form-group has-feedback">
                    <label><?= __('source_id') ?></label>
                    <div class="div">
                        <?= $this->Form->control('source_id', [
                            'class' => 'form-control has-feedback-left',
                            'label' => false,
                            'type' => 'select', 
                            'options' => $optionsSource, 
                            'empty' => 'Select source_id', 
                            'ng-model' => 'rec.sales.source_id',
                        ]) ?>
                        <span class="fa fa-sale form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>
                

                <div class="col-md-6 col-sm-6 form-group has-feedback">
                    <label><?= __('pool_id') ?></label>
                    <div class="div">
                        <?= $this->Form->control('pool_id', [
                            'class' => 'form-control has-feedback-left',
                            'label' => false,
                            'type' => 'select', 
                            'options' => $optionsPool,
                            'empty' => 'Select pool_id',
                            'ng-model' => 'rec.sales.pool_id',
                        ]) ?>
                        <span class="fa fa-sale form-control-feedback left" aria-hidden="true"></span>
                    </div>
                </div>



                    <div class="col-md-6 col-6  form-group has-feedback">
							<label><?= __('sale_current_stage') ?></label>
							<div class="div">
								<?= $this->Form->text('sale_current_stage', [
									'type' => 'select',
									'options'=>$this->Do->lcl( $this->Do->get('current_stage') ),
									'class' => 'form-control has-feedback-left',
									'ng-model' => 'rec.sales.sale_current_stage'
								]) ?>
								<span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
	
                        
                        
                    
                    
                    <!--
                    
                    <div ng-repeat="item in specs track by $index" class="col-md-6 col-sm-6 form-group">
                        <label>{{item}}</label>
                        <div class="div">
                            <input class="form-control" type="hidden" ng-model="rec.sales.sale_specs[$index].spec_name = item " placeholder="{{item}}">
                            <input class="form-control" type="text" ng-model="rec.sales.sale_specs[$index].spec_value" placeholder="{{item}}">
                        </div>
                    </div> -->

                    {{rec.client.client_specs}}
                    


                    <div class="col-md-12 col-sm-12 form-group has-feedback">
                        <button type="submit" class="btn btn-info" id="sale_preloader"><span></span> 
                        <i class="fa fa-save"></i> <?=__('save')?></button>
                    </div>
                    
                    
                    
                </form>

            <button type="button" id="clientAdd_btn" class="hideIt" ng-click="
                doGet('/admin/clients/index?list=1', 'list', 'sales');   rec.sales = {};
                doClick('.close');"></button>

                <!-- Client form -->
                <form class="row" id="clientAdd_form" ng-show="showAddClientForm" ng-submit="
                doSave(rec.client, 'client', 'clients', '#clientAdd_btn', '#clientAdd_preloader');">

                    <!-- Existing form fields ... -->
                    <div class="col-md-6 col-sm-6  form-group has-feedback">
                        <label set-required><?=__('client_name')?></label>
                        <div class="div">
                            <?=$this->Form->control('client_name', [
                                'class'=>'form-control has-feedback-left',
                                'label'=>false,
                                'type'=>'text',
                                'ng-model'=>'rec.client.client_name',
                                'placeholder'=>__('client_name'),
                            ])?>
                            <span class="fa fa-client form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                
                    <div ng-repeat="item in rec.client.client_specs track by $index" class="col-md-6 col-sm-6 form-group">
                        <label>{{item.spec_name}}</label>
                        <div class="div">
                            <input class="form-control" type="text" ng-model="rec.client.client_specs[$index].spec_value" placeholder="{{item.spec_name}}">
                        </div>
                    </div>
                 

                    <div class="col-md-12 col-sm-12 form-group has-feedback">
                        <button type="submit" class="btn btn-info" id="clientAdd_preloader" ng-click="saveClientAndRefresh()"><span></span> 
                        <i class="fa fa-save"></i> <?=__('save')?></button>
                    </div>
                </form>

                

            </div>
        </div>
    </div>
</div>

