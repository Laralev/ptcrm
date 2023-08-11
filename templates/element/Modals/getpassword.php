

<div class="modal fade" tabindex="-1" id="getpassword_mdl" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  col-12"><?= __('getpassword') ?></h5>
                <button type="button" class="btn btn-default close" data-dismiss="modal" aria-label="Close">
                    <i class="icon-cancel"></i>
                </button>
            </div>
            
            <div class="modal-body row">

            <div class="col-12 mb-2">
                <div class="col-12">
                    <h3> <?= __('enter_your_email') ?> </h3>
                </div>
                <div class="col-12 mb-2">
                    <form method="post" novalidate="novalidate" ng-submit="doGetPassword();" id="getpassword_form" class="row">
                        <div class="from-group mb-2 col-12">
                            <?= $this->Form->control("email", [
                                "class" => "form-control", "type" => "email", "ng-model" => "userdt.email", "placeholder" => __("email"), "label" => false,
                                'templates' => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                        <div class="from-group col-12">
                            <button class="btn btn-secondary" id="getpassword_btn" type="submit">
                                <span><i class="icon-lock"></i></span> <?= __('submit') ?>
                            </button>
                            <button class="btn btn-default" type="button" ng-click="openModal('#login_mdl');">
                                <i class="icon-login"></i> <?= __('login') ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>