


<div class="modal fade" id="viewClient_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?= __('view') ?>
                </h4>
            </div>

            <div class="modal-body row">
                <div class="col-md-12 col-sm-12">
                    <div class="view_page">
                        <div class="grid">

                            <div class="grid_row row">
                                <h4 class="col-12">
                                    {{rec.client.client_name}}
                                </h4>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Creation Date')?></div>
                                <div class="col-md-9 notwrapped">{{rec.client.stat_created}}</div>
                            </div>

                            
                            <!-- Display Lead Info data -->
                                <div class="grid_row row">
                                    <h5 class="col-md-12">Lead Info</h5>
                                    <div class="col-md-12" ng-repeat="itm in rec.client.client_specs">
                                        <div ng-if="['Country', 'Client Category', 'Booking Date', 'Source of Query'].includes(itm.spec_name)">
                                            <div class="col-md-9 notwrapped">{{ itm.spec_value }}</div>
                                        </div>
                                    </div>
                                </div>
                            

                            <!-- Display Lead Contact data -->
                                <div class="grid_row row">
                                    <h5 class="col-md-12">Lead Contact</h5>
                                    <div class="col-md-9 notwrapped ml-2">{{rec.client.client_name}}</div>
                                    <div class="col-md-12" ng-repeat="itm in rec.client.client_specs">
                                        <div ng-if="['Mobile', 'Email', 'Email Secondary 1', 'Email Secondary 2'].includes(itm.spec_name)">
                                            <div class="col-md-9">{{ itm.spec_value }}</div>
                                        </div>
                                    </div>
                                </div>
                            
                            
                            
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Status')?></div>
                                <div class="col-md-9 notwrapped" ng-bind-html="DtSetter( 'bool2', rec.client.rec_state )"></div>
                            </div>

                            <div class="grid_row row">
                                    <h5 class="col-md-12">Notes</h5>
                                    <div ng-repeat="itm in rec.client.client_specs">
                                        <div ng-if="['Specific Propert Ref'].includes(itm.spec_name)">
                                            <div class="col-md-3 grid_header2">{{ itm.spec_name }}</div>
                                            <div class="col-md-9 notwrapped ">{{ itm.spec_value }}</div>
                                        </div>
                                    </div>
                                </div>

                                <?php echo $this->element('Modals/viewReport')?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>