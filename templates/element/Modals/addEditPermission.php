

<!-- addEditPermission_mdl modal -->
<div class="modal fade" id="addEditPermission_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal header and title -->
            <!-- ... (existing code) ... -->

            <div class="modal-body">
                <button type="button" id="permission_btn" class="hideIt" ng-click="doGet('/admin/permissions/index?list=1', 'list', 'permissions');   rec.permissions = {}; doClick('.close');"></button>

                <!-- Permission form -->
                <form class="row" id="permission_form" ng-submit="
                doSave(rec.permission, 'permission', 'permissions', '#permission_btn', 
                '#permission_preloader');">

                <?php if(in_array($authUser['user_role'], ['admin.root', 'admin.admin'])){?>
            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label set-required><?=__('permission_role')?></label>
                <div class="div">
                    <?=$this->Form->control('permission_role', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'select',
                        'ng-model'=>'rec.permission.permission_role',
                        'options'=>$this->Do->lcl( $this->Do->get('roles') ),
                        'empty'=>__('select_role'),
                    ])?>
                    <span class="fa fa-flash form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <?php }?>
                
                <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label set-required><?=__('permission_module')?></label>
                                <div class="div">
                                    <?=$this->Form->control('permission_module', [
                                        'class'=>'form-control has-feedback-left',
                                        'label'=>false,
                                        'type'=>'text',
                                        'ng-model'=>'rec.permission.permission_module',
                                        'placeholder'=>__('permission_module'),
                                    ])?>
                                    <span class="fa fa-report form-control-feedback left border-0" aria-hidden="true"></span>
                                </div>
                            </div>


                            <div class="col-3 form-group has-feedback">
                                <div class="div d-flex ">
                                <label set-required><?= __('permission_c') ?></label>

                                    <label class="checkbox-label pl-4">
                                        <?= $this->Form->checkbox('permission_c', [
                                            'class' => 'form-check-input',
                                            'ng-model' => 'rec.permission.permission_c',
                                            'ng-true-value' => "'1'",
                                            'ng-false-value' => "'0'", ]) ?>
                                        
                                    </label>
                                    <span class="fa fa-report form-control-feedback left border-0" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-3 form-group has-feedback">
                                <div class="div d-flex ">
                                <label set-required><?= __('permission_r') ?></label>

                                    <label class="checkbox-label pl-4">
                                        <?= $this->Form->checkbox('permission_r', [
                                            'class' => 'form-check-input',
                                            'ng-model' => 'rec.permission.permission_r',
                                            'ng-true-value' => "'1'",
                                            'ng-false-value' => "'0'",
                                        ]) ?>
                                        
                                    </label>
                                    <span class="fa fa-report form-control-feedback left border-0" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-3 form-group has-feedback">
                                <div class="div d-flex ">
                                <label set-required><?= __('permission_u') ?></label>

                                    <label class="checkbox-label pl-4">
                                        <?= $this->Form->checkbox('permission_u', [
                                            'class' => 'form-check-input',
                                            'ng-model' => 'rec.permission.permission_u',
                                            'ng-true-value' => "'1'",
                                            'ng-false-value' => "'0'",
                                        ]) ?>
                                        
                                    </label>
                                    <span class="fa fa-report form-control-feedback left border-0" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-3 form-group has-feedback">
                                <div class="div d-flex ">
                                <label set-required><?= __('permission_d') ?></label>

                                    <label class="checkbox-label pl-4">
                                        <?= $this->Form->checkbox('permission_d', [
                                            'class' => 'form-check-input',
                                            'ng-model' => 'rec.permission.permission_d',
                                            'ng-true-value' => "'1'",
                                            'ng-false-value' => "'0'",
                                        ]) ?>
                                        
                                    </label>
                                    <span class="fa fa-report form-control-feedback left border-0" aria-hidden="true"></span>
                                </div>
                            </div>


                    <div class="col-md-12 col-sm-12 form-group has-feedback">
                        <button type="submit" class="btn btn-info" id="permission_preloader"><span></span> 
                        <i class="fa fa-save"></i> <?=__('save')?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
