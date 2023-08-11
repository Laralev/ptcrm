

<div class="modal fade" tabindex="-1" id="register_mdl" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title col-12"><?= __('register') ?></h5>
                <button type="button" class="btn btn-default close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-cancel"></i>
                </button>
            </div>

            <div class="modal-body row" id="accordion">
                
                <div class="col-12 ">

                    <div class="col-12 ">
                        <button ng-click="authenticate('google')" class="btn btn-socialmedia btn-google w-100">
                            <i class="icon-google"></i> <?= __('register_with_google') ?>
                        </button>
                    </div>
                    <?php /* <div class="col-12 mb-1">
                        <button ng-click="authenticate('facebook')" class="btn btn-primary w-100">
                            <i class="icon-facebook"></i> <?= __('register_with_facebook') ?>
                        </button>
                    </div> */?>
                    <hr />

                    <div class="col-12 ">
                        <button class="btn btn-default" data-toggle="collapse" data-target="#reg_form">
                            <i class="icon-mail"></i> <?= __('register_with_email') ?>
                        </button> 
                    </div>
                    <?php /*?> <button ng-click="authenticate('github')">Sign in with GitHub</button>
                    <button ng-click="authenticate('linkedin')">Sign in with LinkedIn</button>
                    <button ng-click="authenticate('instagram')">Sign in with Instagram</button>
                    <button ng-click="authenticate('twitter')">Sign in with Twitter</button>
                    <button ng-click="authenticate('foursquare')">Sign in with Foursquare</button>
                    <button ng-click="authenticate('yahoo')">Sign in with Yahoo</button>
                    <button ng-click="authenticate('live')">Sign in with Windows Live</button>
                    <button ng-click="authenticate('twitch')">Sign in with Twitch</button>
                    <button ng-click="authenticate('bitbucket')">Sign in with Bitbucket</button>
                    <button ng-click="authenticate('spotify')">Sign in with Spotify</button> -->

                    <!-- <button ng-click="logout()">Logout</button>
                    <button ng-click="isAuth()">Is authenticate</button> <?php */?>

                </div>
                <div class="col-12 ">
                    <form method="post" novalidate="novalidate" ng-submit="doRegister();" 
                         class="collapse mt-2" id="reg_form" data-parent="#accordion">
                        <div class="col-12  mb-2" set-required>
                            <?= $this->Form->email("email", ["type" => "email", "class" => "form-control ltr", "placeholder" => __("email"), "ng-model" => "userdt.email"]) ?>
                        </div>
                        <div class="col-12  mb-2" set-required>
                            <?= $this->Form->password("password", ["type" => "password", "class" => "form-control", "placeholder" => __("password"), "ng-model" => "userdt.password"]) ?>
                        </div>
                        <div class="col-12  mb-2" set-required>
                            <?= $this->Form->text("user_fullname", ["type" => "text", "class" => "form-control", "placeholder" => __("user_fullname"), "ng-model" => "userdt.user_fullname"]) ?>
                        </div>
                        <div class="col-12  mb-2">
                            <?= $this->Form->text("profile[profile_configs][adrs]", ["type" => "text", "class" => "form-control", "placeholder" => __("adrs"), "ng-model" => "userdt.profile.profile_configs.adrs"]) ?>
                        </div>
                        <div class="col-12 ">
                            <?= $this->Form->password("profile[profile_configs][mob]", ["type" => "tel", "only-numbers" => "", "maxlength" => "14", "class" => "form-control", "placeholder" => __("mobile"), "ng-model" => "userdt.profile.profile_configs.mob"]) ?>
                        </div>
                        <div class="col-12  mb-2" set-required>
                            <label class="mycheckbox" name="iagree">
                                <input type="checkbox" id="iagree" ng-model="userdt.iagree" ng-false-value="false" ng-true-value="true">
                                <span></span> <?= __('must_agreed') ?> <a target="_blank" href="<?= $app_folder ?>/pages/privacy-policy"><?= __('terms_conditions') ?></a>
                            </label>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success" id="register_btn">
                                <span><i class="icon-user-plus"></i></span> <?= __('create_account') ?>
                            </button>
                        </div>
                    </form>
                    <hr/>
                    <div class="col-12">
                        <button class="btn btn-default" ng-click="openModal('#login_mdl');">
                            <i class="icon-login"></i> <?= __('login') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>