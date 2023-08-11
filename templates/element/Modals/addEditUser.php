<div class="modal fade" id="addEditUser_mdl" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="listing-modal-1 modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
            <div ng-if="!rec.user.id"><?=__('add_user')?></div>
            <div ng-if="rec.user.id"><?=__('edit_user')?></div>
        </h4>
      </div>
      <div class="modal-body">

        <button type="button" id="user_btn" class="hideIt" ng-click="
            doGet('/admin/users/index?list=1', 'list', 'users');
            rec.user.id>0 ? '' : rec.user = {};
            doClick('.close');
          "></button>

        <form class="row" id="user_form" ng-submit="
            rec.user.img = filesInfo.user_photos;
            doSave(rec.user, 'user', 'users', '#user_btn', '#user_preloader');">


            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label set-required><?=__('user_fullname')?></label>
                <div class="div">
                    <?=$this->Form->control('user_fullname', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'text',
                        'ng-model'=>'rec.user.user_fullname',
                        'placeholder'=>__('user_fullname'),
                    ])?>
                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>

            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label set-required><?=__('email')?></label>
                <div class="div">
                    <?=$this->Form->control('email', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'email',
                        'ng-model'=>'rec.user.email',
                        'placeholder'=>__('email'),
                    ])?>
                    <span class="fa fa-at form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label set-required><?=__('password')?></label>
                <div class="div">
                    <?=$this->Form->control('password', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'password',
                        'ng-model'=>'rec.user.password',
                        'placeholder'=>__('password'),
                    ])?>
                    <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 mb-2 mt-2"> </div>
            
            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label><?=__('mobile')?></label>
                <div class="div">
                    <?=$this->Form->control('user_configs[mobile]', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'tel',
                        'only-numbers'=>'',
                        'ng-model'=>'rec.user.user_configs.mobile',
                        'placeholder'=>__('mobile'),
                    ])?>
                    <span class="fa fa-mobile form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12  form-group has-feedback">
                <label><?=__('address')?></label>
                <div class="div">
                    <?=$this->Form->control('user_configs[address]', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'textarea',
                        'ng-model'=>'rec.user.user_configs.address',
                        'placeholder'=>__('address'),
                    ])?>
                    <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            
            <?php if(in_array($authUser['user_role'], ['admin.root', 'admin.admin'])){?>
            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label set-required><?=__('user_role')?></label>
                <div class="div">
                    <?=$this->Form->control('user_role', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'select',
                        'ng-model'=>'rec.user.user_role',
                        'options'=>$this->Do->lcl( $this->Do->get('roles') ),
                        'empty'=>__('select_role'),
                    ])?>
                    <span class="fa fa-flash form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <?php }?>

            <div class="clearfix"></div>

            <div class="col-md-12 col-sm-12  form-group has-feedback ">
                <button type="submit" class="btn btn-info" id="user_preloader"><span></span> <i class="fa fa-save"></i> <?=__('save')?></button>
            </div>

        </form>
        <div set-required="msg">ssss</div>

      </div>
    </div>
  </div>
</div>