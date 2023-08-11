<style>
    
    /* .search-input {
        position: relative;
    }
    
    input{
        
        width: 75%;
        border: 1px solid #ced4da;
        border-radius: 0;
        padding-top: 8px;
        padding-bottom: 8px;
        box-shadow: 0px 1px 8px rgba(0, 0, 0, 0.2);
    }

    input:focus{
        box-shadow: inset 0px 1px 8px rgba(0, 0, 0, 0.1);
    }

    
    .filter-input {
        position: relative;
        display: inline-block;
    }

   
    #rec-state{
        width: 162px;
        border: 1px solid gray;
        border-radius: 1px;
        background-color: white;
        padding: 3px;
    }

    .form-group {
        position: relative;
        
    }

    .btnIcon {
        position: absolute;
        top: 0;
        right: 0;
        width: 15%;
    } */


</style>

<?php
    $ctrl = strtolower($this->request->getParam('controller'));
    $from = $this->request->getQuery('from');
    $to = $this->request->getQuery('to');
    $method = empty($method) ? (isset($search) ? 'like' : 'filter') : $method;
    if($ctrl != 'results'){
?>

<div style="min-width: 80px;">

    <?php if(isset($col)){ // Sort by column?>
        
            <span>
                <a href class="btnIconsort" ng-click="
                    sort['<?=$col?>'] = sort['<?=$col?>'] == 'ASC' ? 'DESC' : 'ASC';
                    rec.search.col = '<?=$col?>';
                    rec.search.direction = sort['<?=$col?>'];
                    doGetDelay('/admin/<?=$url?>?from=<?=@$from?>&to=<?=@$to?>&direction='+sort['<?=$col?>']+'&col=<?=$col?>&list=1', 'list', '<?=$ctrl?>');
                "> 
                    <i class="fa fa-{{sort['<?=$col?>']=='ASC' ? 'sort-amount-asc' : 'sort-amount-desc'}}"></i> 
                </a>
            </span>
    <?php } ?>

    <?php if(isset($search)){ // Search keyword?>
    
    <div class="search-input">
        
        <?=$this->Form->control($col, [
                'empty'=>true,
                'label'=>false,
                'type'=>'text',
                'name'=>false,
                'ng-model'=>'filter.kword',
                'ng-change' => "
                    doGetDelay('/admin/clients/index/?from=".@$from."&to=".@$to."&k='+filter.kword+'&col=".$search."&method=".$method."&list=1' , 'list', '".$ctrl."');
                ",
                
            ]) ?>

            
                 <button href class="btnIcon rounded btn btn-info" ng-click="
            isSearch['<?=$col?>'] == 'open' ? isSearch = [] :  isSearch = [] ; 
            isSearch['<?=$col?>'] = 'open';
        ">
            <i class="fa fa-search"></i>
            </button>
            
        
        </div>
        

    <?php } ?>
    

    <?php if(isset($specs)){ // Search keyword?>
    
    <div ng-repeat="item in specs" class="filter-group" >
        <label>{{item}}</label>
        <div class="div">
            <?=$this->Form->control($col, [
                'empty'=>true,
                'label'=>false,
                'type'=>'hidden',
                'name'=>false,
                'ng-model'=>'rec.client.client_specs[$index].spec_name = item',
                
            ]) ?>
            <?=$this->Form->control($col, [
                'empty'=>true,
                'label'=>false,
                'type'=>'text',
                'name'=>false,
                'ng-model'=>'rec.client.client_specs[$index].spec_value',
            ]) ?>
        </div>
    </div>


    <?php } ?>


    <?php if(isset($filter)){ // Filter value?>
        <div class="filter-input">
        <?=$this->Form->control($col, [
                'label'=>false,
                'empty'=>true,
                'type'=>'select',
                'ng-model'=>'filter.kword',
                'options'=>$filter,
                'ng-change' => "
                    rec.search.".$col."=filter.kword; 
                    doGetDelay('/admin/".$url."?from=".$from."&to=".$to."&k='+filter.kword+'&col=".$col."&method=".$method."&list=1' , 'list', '".$ctrl."');
                "
            ])?>
        
    </div>               
    <?php } ?>



 </div>

 <?php } ?>
