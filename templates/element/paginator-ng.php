<?php 
    $path = strtolower( $this->request->getParam('controller') );
    $params = empty($this->request->params['?']) ? '' : http_build_query($this->request->params['?']);
?>
<?php if(in_array($path, ['properties', 'projects'])){ ?>
<div class="paginator">
    <div  ng-if="paging.count > paging.perPage" class="pagination">
        <span class="page-item" ng-class="{disabled: paging.page<2}"> <a href="javascript:void(0);" class="page-link"
            ng-click="rec.search.page=1; doSearch(true); toElm();">
            <i class="fa fa-angle-double-left"></i>
        </a> </span>
        
        <span class="page-item" ng-class="{disabled: paging.page<2}"> <a href="javascript:void(0);" class="page-link"
            ng-click="rec.search.page=(paging.page-1); doSearch(true); toElm();">
            <i class="fa fa-chevron-left"></i>
        </a> </span> 

        <span ng-repeat="page in pager( paging.pageCount, paging.page ) track by $index" 
            class="page-item" ng-class="{active : page == paging.page*1}"> <a href="javascript:void(0);" class="page-link"
            ng-click="rec.search.page=page; doSearch(true); toElm();">
            <span>{{page}}</span>
        </a> </span> 
        
        <span class="page-item" ng-class="{disabled: paging.page >= paging.pageCount}" > <a href="javascript:void(0);" class="page-link"
            ng-click="rec.search.page=(paging.page+1); doSearch(true); toElm();">
            <i class="fa fa-chevron-right"></i>
        </a> </span>
        
        <span class="page-item" ng-class="{disabled: paging.page >= paging.pageCount}" > <a href="javascript:void(0);" class="page-link"
            ng-click="rec.search.page=paging.pageCount; doSearch(true); toElm();">
            <i class="fa fa-angle-double-right"></i>
        </a> </span> 
    </div>
    <span class="paginator_info" ng-if="paging.count>0">

        <?=__('show').' '.__('from')?> 
            {{ paging.start  }} <?=__('to')?> 
            {{ paging.end }} <?=__('of')?> {{ paging.count }} 
            
    </span>
</div>
<?php }else{ ?>
<div class="paginator">
    <div  ng-if="paging.count > paging.perPage" class="pagination">
        <span class="page-item" ng-class="{disabled: paging.page<2}"> <a href="javascript:void(0);" class="page-link"
            ng-click="doGet('/admin/<?=$path?>?page=1&list=1&<?=$params?>', 'list', '<?=$path?>'); toElm();">
            <i class="fa fa-angle-double-left"></i>
        </a> </span>
        
        <span class="page-item" ng-class="{disabled: paging.page<2}"> <a href="javascript:void(0);" class="page-link"
            ng-click="doGet('/admin/<?=$path?>?page='+(paging.page-1)+'&list=1&<?=$params?>', 'list', '<?=$path?>'); toElm();">
            <i class="fa fa-chevron-left"></i>
        </a> </span> 

        <span ng-repeat="page in pager( paging.pageCount, paging.page ) track by $index" 
            class="page-item" ng-class="{active : page == paging.page*1}"> <a href="javascript:void(0);" class="page-link"
            ng-click="doGet('/admin/<?=$path?>?page='+(page)+'&list=1&<?=$params?>', 'list', '<?=$path?>'); toElm();">
            <span>{{page}}</span>
        </a> </span> 
        
        <span class="page-item" ng-class="{disabled: paging.page >= paging.pageCount}" > <a href="javascript:void(0);" class="page-link"
            ng-click="doGet('/admin/<?=$path?>?page='+(paging.page+1)+'&list=1&<?=$params?>', 'list', '<?=$path?>'); toElm();">
            <i class="fa fa-chevron-right"></i>
        </a> </span>
        
        <span class="page-item" ng-class="{disabled: paging.page >= paging.pageCount}" > <a href="javascript:void(0);" class="page-link"
            ng-click="doGet('/admin/<?=$path?>?page='+paging.pageCount+'&list=1&<?=$params?>', 'list', '<?=$path?>'); toElm();">
            <i class="fa fa-angle-double-right"></i>
        </a> </span> 
    </div>
    <span class="paginator_info" ng-if="paging.count>0">

        <?=__('show').' '.__('from')?> 
            {{ paging.start  }} <?=__('to')?> 
            {{ paging.end }} <?=__('of')?> {{ paging.count }} 
            
    </span>
</div>
<?php } ?>