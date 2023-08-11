

<div class="right_col" role="main" 
     ng-init="
        doGet('/admin/users?id=<?=$authUser['id']?>', 'rec', 'user');
    ">

<button type="button" id="user_btn" class="hideIt" ng-click="
    filesInfo.user_photos=[];
    doGet('/admin/users?id=<?=$authUser['id']?>', 'rec', 'user');
    "></button>
 
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?=__('edit_user')?></h3>
            </div>
            <div class="title_right">
                
            </div>
        </div>

        <div class="clearfix"></div>

        <form class="row" ng-submit="
            rec.user.img = filesInfo.user_photos;
            doSave(rec.user, 'user', 'users', '#user_btn', '#user_preloader'); ">
            
            <!-- USER INFO SECTION -->
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-user"></i> <?=__('user_info')?></h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content" >
                        
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <label><?=__('user_fullname')?></label>
                            <div class="div">
                                <?=$this->Form->control('user_fullname', [
                                    'class'=>'form-control has-feedback-left',
                                    'label'=>false,
                                    'type'=>'text',
                                    'ng-model'=>'rec.user.user_fullname',
                                    'placeholder'=>__('user_fullname'),
                                    'disabled'=>'disabled'
                                ])?>
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <label><?=__('password')?></label>
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

                        <div class="clearfix"></div>

                        <div class="form-group ">
                            <div class="col-md-6 col-sm-6  form-group has-feedback ">
                                <button type="submit" id="user_preloader" class="btn btn-info"><span></span> <i class="fa fa-save"></i> <?=__('save')?></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
