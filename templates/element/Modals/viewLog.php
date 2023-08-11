<div class="modal fade" id="viewLog_mdl" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <b><?=__('user')?>: </b>{{rec.log.user.user_fullname}}
                                </h4>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('log_url')?></div>
                                <div class="col-md-9 notwrapped">
                                    <b><?=__('section')?>:</b> {{rec.log.log_url[5]}} / 
                                    <b><?=__('action')?>:</b> 
                                    <span  class="badge badge-{{actionsClr[rec.log.log_url[6]]}}">{{DtSetter( 'actionsName', rec.log.log_url[6] )}}</span> / 
                                    <b><?=__('id')?>:</b> {{rec.log.log_url[7]}}
                                </div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('log_changes')?></div>
                                <div class="col-md-9 notwrapped">
                                    
                                    <div ng-if="rec.log.log_changes.length > 1">

                                        <h5 class="badge badge-info"><?=__('before')?></h5>
                                        <div ng-repeat="(k, v) in rec.log.log_changes[1]">
                                            <b>{{k}}</b>: {{v}}
                                        </div>

                                        <h5 class="badge badge-warning"><?=__('after')?></h5>
                                        <div ng-repeat="(k, v) in rec.log.log_changes[0]">
                                            <b>{{k}}</b>: {{v}}
                                        </div>
                                    </div>
                                    
                                    <div ng-if="rec.log.log_changes.length < 2">
                                        <div ng-repeat="(k, v) in rec.log.log_changes[0]">
                                            <b>{{k}}</b>: {{v}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('stat_created')?></div>
                                <div class="col-md-9 notwrapped">{{rec.log.stat_created}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('rec_state')?></div>
                                <div class="col-md-9 notwrapped" ng-bind-html="DtSetter( 'bool2', rec.log.rec_state )"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>