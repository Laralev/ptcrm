<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <?=$this->Html->image('/img/user.png', ["class"=>"img-circle", "alt"=>"..."])?>
    </div>
    <div class="profile_info">
        <?=$authUser["user_fullname"]?>
    </div>
</div>
<!-- /menu profile quick info -->