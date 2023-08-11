
<div class="right_col" role="main" ng-init="
        doGet('/admin/logs/index?list=1', 'list', 'logs');
    ">
    <div class="">
        <div class="page-title">
            <div class=" col-6 col-sm-6 col-md-6 side_div1">
                <h3><?=__('logs_list')?></h3>
            </div>
            <div class=" col-6 col-sm-6 col-md-6 side_div2" >
                <span class="icn">
                    <a href  data-toggle="modal" data-target="#search_mdl" data-dismiss="modal"  class="btn btn-info">
                        <span class="fa fa-search"></span> <span class="hideMob"><?=__('search')?></span>
                    </a>
                </span>
            </div>
        </div>

        <div class="clearfix"></div>

        
        <div class="row">
            <div class="col-12">
                <div class="x_panel">

                <!-- <iframe src="https://drive.google.com/file/d/1PN3DgVrwYfiqXAvLG_Q1C7EONaWMMci3/preview" width="640" height="480" allow="autoplay"></iframe> -->

                    <div id="main_preloader" class="preloader">
                        <div>
                            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                        </div>
                        <div><?=__('please_wait')?></div>
                    </div>
                    
                    <div class="x_title">
                        <h2><b><?=__('logs_list')?></b> 
                            <span> <?=__('show').' '.__('from')?> 
                                {{ paging.start  }} <?=__('to')?> 
                                {{ paging.end }} <?=__('of')?> {{ paging.count }} </span></h2>
                        
                        <?php if(in_array($authUser['user_role'], ['admin.root'])){?>
                        <ul class="nav navbar-right panel_toolbox">
                            <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li> -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu  <?= $currlang!='ar' ? 'dropdown-menu-right' : ''?>">
                                    <a href ng-click="multiHandle('/admin/logs/delete')" class="dropdown-item">
                                        <i class="fa fa-trash"></i> <?=__('delete_selected')?>
                                    </a>
                                    <a href ng-click="multiHandle('/admin/logs/enable/1')" class="dropdown-item">
                                        <i class="fa fa-check"></i> <?=__('enable_selected')?>
                                    </a>
                                    <a href ng-click="multiHandle('/admin/logs/enable/0')" class="dropdown-item">
                                        <i class="fa fa-times"></i> <?=__('disable_selected')?>
                                    </a>
                                </div>
                            </li>
                            <!-- <li><a class="close-link"><i class="fa fa-close"></i></a> 
                            </li>-->
                        </ul>
                        <?php }?>
                        
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <div class="grid ">

                            <div class="grid_header row">

                                <?php if(in_array($authUser['user_role'], ['admin.root', 'admin.admin', 'admin.supervisor'])){?>
                                <div class="col-sm-1 col column-title">
                                    <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'id'])?>
                                    <label class="mycheckbox">
                                        <input type="checkbox" ng-click="chkAll('.chkb', !selectAll)" ng-model="selectAll">
                                        <span></span> 
                                        <?=__('id')?> 
                                    </label> 
                                </div>
                                <?php }?>
                                
                                <div class="col-sm-2 col column-title">
                                    <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'user_fullname', 'search'=>'user_fullname'])?> 
                                    <?=__('user_fullname')?> </div>
                                
                                <div class="col-sm-5 col column-title">
                                    <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'log_url', 'search'=>'log_url'])?> 
                                    <?=__('log_url')?> </div>

                                <div class="col-sm-2 col column-title">
                                    <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'stat_created'])?> 
                                    <?=__('stat_created')?> </div>

                                <div class="col-sm-2 col column-title hideMob"><span
                                        class="nobr"><?=__('action')?></span>
                                </div>
                            </div>
                            
                            <div class="grid_row row" ng-repeat="itm in lists.logs">

                                <?php if(in_array($authUser['user_role'], ['admin.root', 'admin.admin', 'admin.supervisor'])){?>
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
                                <?php }?>

                                <div class="col-4 hideWeb grid_header"><?=__('user_fullname')?></div>
                                <div class="col-md-2 col-8">
                                    <a href="javascript:void(0);" title="{{DtSetter('roles', itm.user.user_role)}}" >
                                        <img ng-src="<?= $app_folder ?>/img/badges/ptbadge{{roles_badge[itm.user.user_role]}}.svg" />
                                    </a>
                                    {{ itm.user.user_fullname }} 
                                </div>
                                
                                <div class="col-4 hideWeb grid_header"><?=__('log_url')?></div>
                                <div class="col-md-5 col-8">
                                    <span>{{ itm.log_url[5] }}</span>/
                                    <span class="badge badge-{{actionsClr[itm.log_url[6]]}}"> {{ DtSetter('actionsName',  itm.log_url[6]) }} </span>/
                                    <span>{{ itm.log_url[7] }}</span>
                                </div>

                                <div class="col-4 hideWeb grid_header"><?=__('stat_created')?></div>
                                <div class="col-md-2 col-8">{{ itm.stat_created }} </div>

                                <div class="col-4 hideWeb grid_header"><?=__('actions')?></div>
                                <div class="col-md-2 col-8 action">
                                    <a href="javascript:void(0);" 
                                        data-toggle="modal" data-target="#viewLog_mdl"  class="inline-btn"
                                        ng-click="doGet('/admin/logs?id='+itm.id, 'rec', 'log');">
                                        <i class="fa fa-eye"></i> <?=__('view')?>
                                    </a> &nbsp; 
                                </div>
                            </div>

                        </div>

                        <?Php /*?>
                        <div class="table-responsive">
                            <table class="table jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">

                                        <?php if(in_array($authUser['user_role'], ['admin.root'])){?>
                                        <th>
                                            <label class="mycheckbox">
                                                <input type="checkbox" ng-click="chkAll('.chkb', !selectAll)" ng-model="selectAll">
                                                <span></span>
                                            </label>
                                        </th>
                                        <th class="column-title">
                                            <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'id'])?>
                                            <?=__('id')?> </th>
                                        <?php }?>

                                        <th class="column-title">
                                            <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'user_fullname', 'search'=>'user_fullname'])?> 
                                            <?=__('user_fullname')?> </th>

                                        <th class="column-title"> <?=__('log_url')?> </th>

                                        <th class="column-title">
                                            <?=$this->element('colActions', ['url'=>'logs/index/', 'col'=>'stat_created'])?> 
                                            <?=__('stat_created')?> </th>

                                        <th class="column-title no-link last"><span
                                                class="nobr"><?=__('action')?></span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr ng-repeat="itm in lists.logs">

                                        <?php if(in_array($authUser['user_role'], ['admin.root'])){?>
                                        <td class="">
                                            <label class="mycheckbox chkb">
                                                <input type="checkbox" ng-model="selected[itm.id]" 
                                                    ng-value="{{itm.id}}">
                                                <span></span>
                                            </label>
                                        </td>
                                        <td class=" ">{{ itm.id }}</td>
                                        <?php }?>

                                        <td class=" ">
                                            <a href="javascript:void(0);" title="{{DtSetter('roles', itm.user.user_role)}}" >
                                                <img ng-src="<?= $app_folder ?>/img/badges/ptbadge{{roles_badge[itm.user.user_role]}}.svg" />
                                            </a>
                                            {{ itm.user.user_fullname }} 
                                        </td>
                                        <td class=" ">
                                            <span>{{ itm.log_url[5] }}</span>/
                                            <span class="badge badge-{{actionsClr[itm.log_url[6]]}}"> {{ DtSetter('actionsName',  itm.log_url[6]) }} </span>/
                                            <span>{{ itm.log_url[7] }}</span>
                                        </td>
                                        <td class=" " >{{ itm.stat_created }} </td>
                                        <td class=" last ">
                                            <a href="<?=$app_folder.'/'.$currlang?>/admin/logs/view/{{itm.id}}">
                                                <i class="fa fa-eye"></i> <?=__('view')?>
                                            </a> &nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <?php */?>

                        <?php echo $this->element('paginator-ng')?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('Modals/search')?>
<?php echo $this->element('Modals/viewLog')?>
