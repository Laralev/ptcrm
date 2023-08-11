<div class="modal fade" id="viewSale_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?= __('view_sale') ?>
                </h4>
            </div>

            <div class="modal-body row">
                <div class="col-md-12 col-sm-12">
                    <div class="view_page">
                        <div class="grid">

                            <div class="grid_row row">
                                <h4 class="col-12">
                                    <i class="fa {{itm.sale_configs.icon||'fa-tag'}}"></i> {{ rec.sales.id }}
                                </h4>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('client_id')?></div>
                                <div class="col-md-9 notwrapped">{{ rec.sales.client_id }}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('source_id')?></div>
                                <div class="col-md-9 notwrapped">{{ rec.sales.source_id }}</div>
                            </div>
 
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('segement_id')?></div>
                                <div class="col-md-9 notwrapped">{{ rec.sales.segement_id }}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('pool_id ')?></div>
                                <div class="col-md-9 notwrapped">{{ rec.sales.pool_id  }}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('sale_current_stage')?></div>
                                <div class="col-md-9 notwrapped">{{ rec.sales.sale_current_stage }}</div>
                            </div>
                            
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('lead_priority')?></div>
                                <div class="col-md-9 notwrapped">{{rec.sales.lead_priority}}</div>
                            </div>
                            
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('rec_state')?></div>
                                <div class="col-md-9 notwrapped" ng-bind-html="DtSetter( 'bool2', rec.sales.rec_state )"></div>
                            </div>

                            <div class="grid_row row" ng-repeat="itm in rec.sales.sale_specs">
                                <div class="col-md-3 grid_header2">{{itm.spec_name}}</div>
                                <div class="col-md-9 notwrapped">{{itm.spec_value}}</div>
                            </div>

                            <?php echo $this->element('Modals/viewReport')?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


