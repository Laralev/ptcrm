

<?php
    $pid = !isset($this->request->getParam('pass')[0]) ? null : $this->request->getParam('pass')[0];
?>

<div class="right_col" role="main" ng-init="
        doGet('/admin/categories/index/<?=$pid?>?list=1', 'list', 'categories');
    ">
    <div class="">
        <div class="page-title">
            <div class=" col-6 col-sm-6 col-md-6 side_div1">
                <h3><?=__('categories_list')?></h3>
            </div>
            <div class=" col-6 col-sm-6 col-md-6 side_div2" >
                <span class="icn">
                    <a href ng-click="
                            newEntity('category');
                            openModal('#addEditCategory_mdl');
                        " class="btn btn-info">
                        <span class="fa fa-plus"></span> <span class="hideMob"><?=__('add_category')?></span>
                    </a>
                </span>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-12">
                <div class="x_panel">

                    <div id="main_preloader" class="preloader">
                        <div>
                            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                        </div>
                        <div><?=__('please_wait')?></div>
                    </div>
                    
                    <div class="x_title">
                        <h2><b><?=__('categories_list')?></b> 
                            <span> <?=__('show').' '.__('from')?> 
                                {{ paging.start  }} <?=__('to')?> 
                                {{ paging.end }} <?=__('of')?> {{ paging.count }} </span></h2>
                        
                        <ul class="nav navbar-right panel_toolbox">
                            <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li> -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu  <?= $currlang!='ar' ? 'dropdown-menu-right' : ''?>">
                                    <a href ng-click="multiHandle('/admin/categories/enable/1')" class="dropdown-item">
                                        <i class="fa fa-check"></i> <?=__('enable_selected')?>
                                    </a>
                                    <a href ng-click="multiHandle('/admin/categories/enable/0')" class="dropdown-item">
                                        <i class="fa fa-times"></i> <?=__('disable_selected')?>
                                    </a>
                                    <a href ng-click="multiHandle('/admin/categories/delete')" class="dropdown-item">
                                        <i class="fa fa-trash"></i> <?=__('delete_selected')?>
                                    </a>
                                </div>
                            </li>
                            <!-- <li><a class="close-link"><i class="fa fa-close"></i></a> 
                            </li>-->
                        </ul>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <div class="grid ">

                            <div class="grid_header row">

                                <div class="col-sm-1 col">
                                    <?=$this->element('colActions', ['url'=>'categories/index/', 'col'=>'id'])?>
                                    <label class="mycheckbox">
                                        <input type="checkbox" ng-click="chkAll('.chkb', !selectAll)" ng-model="selectAll">
                                        <span></span> 
                                        <?=__('id')?> 
                                    </label> 
                                </div>
                                
                                <div class="col-sm-5 col">
                                    <?=$this->element('colActions', ['url'=>'categories/index/', 'col'=>'category_name' ])?> 
                                    <?=__('category_name')?> </div>
                                
                                <div class="col-sm-1 col">
                                    <?=$this->element('colActions', ['url'=>'categories/index/', 'col'=>'language_id' ])?> 
                                    <?=__('language_id')?> </div>

                                <div class="col-sm-1 col">
                                    <?=$this->element('colActions', ['url'=>'categories/index/', 'col'=>'parent_id' ])?> 
                                    <?=__('parent_id')?> </div>

                                <div class="col-sm-1 col">
                                    <?=$this->element('colActions', ['url'=>'categories/index/', 'col'=>'rec_state' ])?> 
                                    <?=__('rec_state')?> </div>

                                <div class="col-sm-3 col hideMob"><span
                                        class="nobr"><?=__('action')?></span>
                                </div>
                            </div>
                            
                            <div class="grid_row row" ng-repeat="itm in lists.categories">
                                
                                <div class="col-sm-1 hideMobSm grid_header">
                                    <label class="mycheckbox chkb">
                                        <input type="checkbox" ng-model="selected[itm.id]" ng-value="{{itm.id}}">
                                        <span></span> {{ itm.id }}
                                    </label>
                                </div>
                                <div class="col-4 hideWeb grid_header">
                                    <?=__('id')?> 
                                    <label class="mycheckbox chkb">
                                        <input type="checkbox" ng-model="selected[itm.id]" ng-value="{{itm.id}}">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-md-1 col-8 hideWeb">{{ itm.id }}</div>

                                <div class="col-4 hideWeb grid_header"><?=__('category_name')?></div>
                                <div class="col-md-5 col-8">
                                    <i class="fa {{itm.category_configs.icon||'fa-tag'}}"></i> {{ itm.category_name }} 
                                </div>

                                <div class="col-4 hideWeb grid_header"><?=__('language_id')?></div>
                                <div class="col-md-1 col-8" ng-bind-html="DtSetter('langs', itm.language_id)"></div>
                                
                                <div class="col-4 hideWeb grid_header"><?=__('parent_id')?></div>
                                <div class="col-md-1 col-8">
                                    <a href="<?=$app_folder?>/admin/categories/index/{{itm.parent_id}}">[{{ itm.parent_id }}]{{itm.parent_category.category_name}}</a></div>

                                <div class="col-4 hideWeb grid_header"><?=__('rec_state')?></div>
                                <div class="col-md-1 col-8" ng-bind-html="DtSetter('bool2', itm.rec_state)"></div>

                                <div class="col-4 hideWeb grid_header"><?=__('actions')?></div>
                                <div class="col-md-3 col-8 action">
                                    <a href ng-click="
                                        rec.category = itm;
                                        openModal('#viewCategory_mdl');
                                        "><i class="fa fa-eye"></i> <?=__('view')?></a>
                                    <a href ng-click=" 
                                        rec.category = itm; 
                                        openModal('#addEditCategory_mdl');
                                        " >
                                        <i class="fa fa-pencil"></i> <?=__('edit')?>
                                    </a>
                                    <a href ng-click=" 
                                        newEntity('category'); 
                                        rec.category.parent_id = itm.id; 
                                        rec.category.parent_name = itm.category_name; 
                                        openModal('#addEditCategory_mdl'); ">
                                        <i class="fa fa-plus"></i> <?=__('add_child')?>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <?php echo $this->element('paginator-ng')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('Modals/addEditCategory')?>
<?php echo $this->element('Modals/viewCategory')?>