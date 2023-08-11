<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>
                <?=__('register')?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form method="post" novalidate="novalidate" ng-submit="doRegister();" id="reg_form" class="row">
                <div class="col-12 mb-4">
                    <?=$this->Form->text("user_fullname", ["type"=>"text", "class"=>"form-control", "placeholder"=>__("user_fullname"), "ng-model"=>"rec.user.user_fullname"])?>
                </div>
                <div class="col-12  mb-4">
                    <?=$this->Form->email("email", ["type"=>"text", "class"=>"form-control", "placeholder"=>__("email"), "ng-model"=>"rec.user.email"])?>
                </div>
                <div class="col-12  mb-2">
                    <?=$this->Form->password("password", ["type"=>"password", "class"=>"form-control", "placeholder"=>__("password"), "ng-model"=>"rec.user.password"])?>
                </div>
                <div class="col-12">
                    <label class="mycheckbox" name="iagree">
                        <input type="checkbox" id="iagree" 
                               ng-model="userdt.iagree"
                               ng-false-value="false"
                               ng-true-value="true"> 
                        <span></span> <?=__('terms_conditions')?>
                    </label>
                </div>
                <div class="col-12">
                    <button class="btn btn-success" id="register_btn">
                    <span><i class="fa fa-user-plus"></i></span> <?=__('create_account')?> 
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <h2>
                <?=__('already_have_account')?>
            </h2>
            <div >
                <p>
                    <?=__('already_have_account_msg')?>
                </p>
                <div class="from-group"> 
                    <a href class="btn btn-primary" data-toggle="modal" data-target="#login_mdl" data-dismiss="modal" >
                        <i class="fa  fa-sign-in"></i> <?=__('login')?> 
                    </a> 
                </div>
            </div>
        </div>
    </div>

</div>
