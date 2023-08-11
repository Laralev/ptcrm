
<!-- addEditClient_mdl modal -->
<div class="modal fade" id="addEditClient_mdl" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="listing-modal-1 modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal header and title -->
            <!-- ... (existing code) ... -->

            <div class="modal-body">

            <button type="button" id="sale_btn" class="hideIt" ng-click=
                "doGet('/admin/sales/index?list=1', 'list', 'sales');   rec.sales = {}; doClick('.close');"></button>




                <button type="button" id="client_btn" class="hideIt" ng-click="
                doGet('/admin/clients/index?list=1', 'list', 'clients');   rec.client = {};
                doClick('.close');"></button>

                <!-- Client form -->
                <form class="row" id="client_form" ng-submit="
                    doSave(rec.client, 'client', 'clients', '#client_btn', '#client_preloader');">

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
                        <button type="submit" class="btn btn-info" id="client_preloader"><span></span> 
                        <i class="fa fa-save"></i> <?=__('save')?></button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
