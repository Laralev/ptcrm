


<div class="modal fade" id="viewPermission_mdl" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    {{rec.permission.permission_role}}
                                </h4>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Permission Module')?></div>
                                <div class="col-md-9 notwrapped">{{rec.permission.permission_module}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Permisson Create')?></div>
                                <div class="col-md-9 notwrapped">{{rec.permission.permission_c}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Permisson Read')?></div>
                                <div class="col-md-9 notwrapped">{{rec.permission.permission_r}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Permisson Update')?></div>
                                <div class="col-md-9 notwrapped">{{rec.permission.permission_u}}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('Permisson Delete')?></div>
                                <div class="col-md-9 notwrapped">{{rec.permission.permission_d}}</div>
                            </div>

        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>