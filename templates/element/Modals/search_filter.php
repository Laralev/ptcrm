<div class="modal fade" id="search_filter_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <div ng-if="!rec.client.id && !rec.client.client_specs"><?=__('Search_and_filter')?></div>
                </h4>
            </div>
            <div class="modal-body">

                <button type="button" id="client_btn" class="hideIt" ng-click="
                    doGet('/admin/clients/index?list=1', 'list', 'clients');
 
                    doClick('.close');
                "></button>

                <form class="row" ng-submit="searchClients()" id="client_form" ng-submit="
                    rec.client.img = filesInfo.client_photos;
                ">


                    <div class="col-12  form-group has-feedback">

                        <label><?=__('client_name')?></label>
                        <?=$this->element('colActions', ['url'=>'clients/index/', 'col'=>'client_name', 'search'=>'client_name'])?>
                        
                        <label><?=__('stat_created')?></label>
                        <?=$this->element('colActions', ['url'=>'clients/index/', 'col'=>'stat_created', 'search'=>'stat_created'])?>
                       

                        <!--for client_specs inputs-->
                        <?=$this->element('colActions', ['url'=>'clients/index/', 'col'=>'specs', 'specs'=>'specs'])?> 
                        
                        
                        <label><?=__('rec_state')?></label>
                        <?=$this->element('colActions', ['url'=>'clients/index/', 'col'=>'rec_state', 'filter'=>$this->Do->lcl( $this->Do->get('bool'))])?> 

                        
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

