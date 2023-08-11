<div class="x_panel col-12 ">
    <form class="filter" ng-submit="doFilter()">
        <h2>
            <?=__('filters')?> <small><?=__('scores')?></small>
        </h2>
        <div class="top_search"> 
            <div class="input-group">
                <?=$this->Form->text('key', [
                    'placeholder'=>__('searchfor'),
                    'class'=>'form-control',
                    'ng-model'=>'search.key',
                    'div'=>false
                ])?>
                <span class="input-group-btn">
                    <button class="bttn btn-default" type="button"><?=__('go')?></button>
                </span>
            </div>
        </div>
        <div class="">
            <label><?=__('from')?>
            <a href ng-click="search.from = setDate('onlydate', [0,0,0,0,0,0])+' 00:00:00'"><?=__('1day')?></a> - 
            <a href ng-click="search.from = setDate('onlydate', [0,0,-1,0,0,0])+' 00:00:00'"><?=__('2day')?></a> - 
            <a href ng-click="search.from = setDate('onlydate', [0,0,-2,0,0,0])+' 00:00:00'"><?=__('3day')?></a>
            </label>
            <?=$this->Form->control('from', [
                'placeholder'=>'Ex: 2020-11-10 12:00:00',
                'class'=>'form-control',
                'style'=>'direction:ltr',
                'type'=>'text',
                'label'=>false,
                'ng-model'=>'search.from'
            ])?>
        </div>
        <div class="">
            <label><?=__('to')?>
            <a href ng-click="search.to = setDate('onlydate', [0,0,0,0,0,0])+' 00:00:00'"><?=__('1day')?></a> - 
            <a href ng-click="search.to = setDate('onlydate', [0,0,-1,0,0,0])+' 00:00:00'"><?=__('2day')?></a> - 
            <a href ng-click="search.to = setDate('onlydate', [0,0,-2,0,0,0])+' 00:00:00'"><?=__('3day')?></a>
            </label>
            <?=$this->Form->control('to', [
                'placeholder'=>'Ex: 2020-12-10 24:60:60',
                'class'=>'form-control',
                'style'=>'direction:ltr',
                'type'=>'text',
                'label'=>false,
                'ng-model'=>'search.to'
            ])?>
        </div>
        <div class="">
            <label><?=__('tar')?></label>
            <?=$this->Form->control('tar', [
                'class'=>'form-control',
                'type'=>'select',
                'options'=>$targetList,
                'label'=>false,
                'ng-model'=>'search.tar',
                'empty'=>__('select_tar')
            ])?>
        </div>
        
        <div class="">
            <button class="btn btn-info" type="submit">
                <i class="fa fa-search"></i> <?=__('go')?>
            </button>
        </div>
    </form>
</div>