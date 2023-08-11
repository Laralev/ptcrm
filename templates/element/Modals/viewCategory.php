<div class="modal fade" id="viewCategory_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?= __('view_category') ?>
                </h4>
            </div>

            <div class="modal-body row">
                <div class="col-md-12 col-sm-12">
                    <div class="view_page">
                        <div class="grid">

                            <div class="grid_row row">
                                <h4 class="col-12">
                                    <i class="fa {{itm.category_configs.icon||'fa-tag'}}"></i> {{ rec.category.category_name }}
                                </h4>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('parent')?></div>
                                <div class="col-md-9 notwrapped">{{ rec.category.parent_category.category_name }}</div>
                            </div>

                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('category_configs')?></div>
                                <div class="col-md-9 notwrapped">
                                    <div><?=__('isProtected')?> {{DtSetter( 'bool1', rec.category.category_configs.isProtected||0 )}}</div>
                                    <div><?=__('icon')?> <i class="fa {{itm.category_configs.icon||'fa-tag'}}"></i> </div>
                                </div>
                            </div>
                            
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('category_priority')?></div>
                                <div class="col-md-9 notwrapped">{{rec.category.category_priority}}</div>
                            </div>
                            
                            <div class="grid_row row">
                                <div class="col-md-3 grid_header2"><?=__('rec_state')?></div>
                                <div class="col-md-9 notwrapped" ng-bind-html="DtSetter( 'bool2', rec.category.rec_state )"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>