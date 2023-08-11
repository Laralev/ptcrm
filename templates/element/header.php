<header class="container-fluid" >

    <div class="row topbar">
        <div class="logo col-4">
            <?=$this->Html->image("/img/logo.png", ["alt"=>__('logo_alt')])?>
        </div>
        <?php if($authUser){?>
            <div class="header_side2 col-8">
                <span><?=$this->Html->link('<i class="fas fa-user"></i> '.$authUser['user_fullname'], 
                    '/admin/myaccount', ['escape'=>false , 'class'=>'smallBtn'])?></span>
                <span><?=$this->Html->link('<i class="fas fa-power-off"></i> '.__('logout'), 
                    ['controller'=>'Users', 'action'=>'logout'], ['escape'=>false, 'class'=>'smallBtn'])?></span>
            </div>
        <?php }?>
    </div>

</header>
