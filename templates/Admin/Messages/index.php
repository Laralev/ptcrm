
<div class="right_col" role="main" ng-init="
        doGet('/admin/messages/index?list=1', 'list', 'messages');
    ">
    <div class="">
        <div class="page-title">
            <div class=" col-12 col-sm-12 side_div1">
                <h3><?=__('messages_list')?></h3>
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
                        <h2><b><?=__('messages_list')?></b> 
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
                                    <a href ng-click="multiHandle('/admin/messages/delete')" class="dropdown-item">
                                        <i class="fa fa-trash"></i> <?=__('delete_selected')?>
                                    </a>
                                    <a href ng-click="multiHandle('/admin/messages/enable/1')" class="dropdown-item">
                                        <i class="fa fa-check"></i> <?=__('enable_selected')?>
                                    </a>
                                    <a href ng-click="multiHandle('/admin/messages/enable/0')" class="dropdown-item">
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
                                            <?=$this->element('colActions', ['url'=>'messages/index/', 'col'=>'id'])?>
                                            <?=__('id')?> </th>
                                        <?php }?>

                                        <th class="column-title"> <?=__('sender')?> </th>

                                        <th class="column-title">
                                            <?=$this->element('colActions', ['url'=>'messages/index/', 'col'=>'parent_id', 'search'=>'parent_id', 'method'=>'filter'])?> 
                                            <?=__('parent_id')?> </th>

                                        <th class="column-title">
                                            <?=$this->element('colActions', ['url'=>'messages/index/', 'col'=>'message_subject', 'search'=>'message_subject'])?> 
                                            <?=__('message_subject')?> </th>
                                            
                                        <th class="column-title">
                                            <?=$this->element('colActions', ['url'=>'messages/index/', 'col'=>'stat_created'])?> 
                                            <?=__('stat_created')?> </th>


                                        <th class="column-title no-link last"><span
                                                class="nobr"><?=__('action')?></span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr ng-repeat="itm in lists.messages">

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

                                        <td class=" ">{{ itm.user.user_fullname }} </td>
                                        <td class=" ">{{ itm.parent_id }} </td>
                                        <td class=" ">{{ itm.message_subject }} </td>
                                        <td class=" ">{{ itm.stat_created }} </td>
                                        <td class=" last ">
                                            <a href="<?=$app_folder.'/'.$currlang?>/admin/messages/view/{{itm.id}}">
                                                <i class="fa fa-eye"></i> <?=__('view')?>
                                            </a> &nbsp;
                                            <!-- <a href="javascript:void(0);"
                                                data-toggle="modal" data-target="#addEditmessage_mdl"
                                                ng-click="rec.message = itm" >
                                                <i class="fa fa-pencil"></i> <?=__('edit')?>
                                            </a> -->
                                        </td>
                                    </tr>


                                </tbody>
                            </table>

                        </div>
                        <?php echo $this->element('paginator-ng')?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
