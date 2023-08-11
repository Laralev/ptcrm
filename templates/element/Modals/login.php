<div class="modal fade" tabindex="-1" id="login_mdl" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title col-12"><?= __('login') ?></h5>
                <button type="button" class="btn btn-default close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-cancel"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-12">
                    <form method="post" novalidate="novalidate" ng-submit="doLogin(userdt);" id="login_form">

                        <div class="col-12 mb-2">
                            <?= $this->Form->control("email", [
                                "class" => "form-control ltr",
                                "type" => "email", "ng-model" => "userdt.email",
                                "placeholder" => __("email"), "label" => false,
                                "templates" => [ "inputContainer" => "{{content}}"]
                            ]) ?>
                        </div>
                        <div class="col-12 mb-2">
                            <?= $this->Form->control("password", [
                                "class" => "form-control",
                                "type" => "password", "ng-model" => "userdt.password",
                                "placeholder" => __("password"), "label" => false,
                                "templates" => [ "inputContainer" => "{{content}}"]
                            ]) ?>
                        </div>
                        <label class="col-12 mb-2 mycheckbox">
                            <input type="checkbox" ng-model="userdt.remember_me"> <span><span> <?= __('remember_me') ?>
                        </label>

                        <div class="col-12 mb-2">
                            <button class="btn btn-success" id="login_btn">
                                <span><i class="icon-login"></i></span> <?= __('login') ?>
                            </button>
                            <button class="btn btn-default" type="button" ng-click="openModal('#getpassword_mdl');">
                                <i class="icon-lock"></i> <?= __('forget_password') ?>
                            </button>
                        </div>
                    </form>
                </div>


                <div class="col-12 mb-2">
                    <div class="">
                        
                        <hr />

                        <div class="col-12 mb-1">
                            <button ng-click="authenticate('google')" class="btn btn-socialmedia btn-google w-100">
                                <i class="icon-google"></i> <?= __('login_with_google') ?>
                            </button>
                        </div>
                        <?php /*?> <div class="col-12 mb-1">
                            <button ng-click="authenticate('facebook')" class="btn btn-primary w-100">
                                <i class="icon-facebook"></i> <?= __('login_with_facebook') ?>
                            </button>
                        </div> <?php */?>

                        <?php /*?> <button g-login type="button">Google Login</button>
                        <button linked-in type="button">LinkedIn Login</button>
                        <button fb-login type="button">facebook Login</button> 
                        <button ng-click="authenticate('github')">Sign in with GitHub</button>
                        <button ng-click="authenticate('linkedin')">Sign in with LinkedIn</button>
                        <button ng-click="authenticate('instagram')">Sign in with Instagram</button>
                        <button ng-click="authenticate('twitter')">Sign in with Twitter</button>
                        <button ng-click="authenticate('foursquare')">Sign in with Foursquare</button>
                        <button ng-click="authenticate('yahoo')">Sign in with Yahoo</button>
                        <button ng-click="authenticate('live')">Sign in with Windows Live</button>
                        <button ng-click="authenticate('twitch')">Sign in with Twitch</button>
                        <button ng-click="authenticate('bitbucket')">Sign in with Bitbucket</button>
                        <button ng-click="authenticate('spotify')">Sign in with Spotify</button> <?php */?>

                        <hr />

                        <div class="col-12">
                            <button class="btn btn-default" ng-click="openModal('#register_mdl');">
                                <i class="icon-user-plus"></i> <?= __('register_new_account') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>