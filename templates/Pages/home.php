<?php
$this->assign('title', __('sitemoto'));
?>


<div class="container">
    <div class="row justify-content-md-center" full-hieght>
        <div class="col-md-6">
            <div class="from-group col mb-3">

                <?php if (!$authUser) { ?>

                    <a href class="" data-toggle="modal" data-target="#getpassword_mdl" data-dismiss="modal">
                        <?= __('forget_password') ?>
                    </a>

                    <a href class="" data-toggle="modal" data-target="#register_mdl" data-dismiss="modal">
                        <?= __('register') ?>
                    </a>

                    <a href class="" data-toggle="modal" data-target="#login_mdl" data-dismiss="modal">
                        <?= __('login') ?>
                    </a>

                <?php } else { ?>
                    <a href="<?=$app_folder?>/admin" >
                        <?= __('admin') ?>
                    </a>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php echo $this->element('Modals/register') ?>
<?php echo $this->element('Modals/login') ?>
<?php echo $this->element('Modals/getpassword') ?>