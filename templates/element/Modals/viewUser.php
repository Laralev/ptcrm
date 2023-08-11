<div class="modal fade" id="viewUser_mdl" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    {{rec.user.user_fullname}}
                                </h4>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('email')?></div>
                                <div class="col-md-9 notwrapped">{{rec.user.email}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('user_role')?></div>
                                <div class="col-md-9 notwrapped">
                                    <a href="javascript:void(0);" title="{{DtSetter('roles', rec.user.user_role)}}" >
                                        <img ng-src="<?= $app_folder ?>/img/badges/ptbadge{{roles_badge[rec.user.user_role]}}.svg" />
                                    </a>
                                    {{DtSetter( 'roles', rec.user.user_role )}}
                                </div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('user_configs')?></div>
                                <div class="col-md-9 notwrapped">
                                    <div> <i class="fa fa-mobile w20px"></i> {{rec.user.user_configs.mobile}} </div>
                                    <div> <i class="fa fa-map-marker w20px"></i> {{rec.user.user_configs.address}} </div>
                                </div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('stat_lastlogin')?></div>
                                <div class="col-md-9 notwrapped">{{rec.user.stat_lastlogin}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('stat_created')?></div>
                                <div class="col-md-9 notwrapped">{{rec.user.stat_created}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('stat_logins')?></div>
                                <div class="col-md-9 notwrapped">{{rec.user.stat_logins}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('stat_ip')?></div>
                                <div class="col-md-9 notwrapped">{{rec.user.stat_ip}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('rec_state')?></div>
                                <div class="col-md-9 notwrapped" ng-bind-html="DtSetter( 'bool2', rec.user.rec_state )"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>