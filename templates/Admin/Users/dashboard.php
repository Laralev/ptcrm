<?php
$from = !isset($_GET['from']) ? date('Y-m-d', strtotime('first day of this month')) : $_GET['from'];
$to = !isset($_GET['to']) ? date('Y-m-d') : $_GET['to'];
?>

<!-- doGet('/admin/configs/statistics', 'rec', 'stats');
      doGetDelay('/admin/configs/notifications', 'rec', 'notifications'); -->
<div class="right_col" role="main" ng-init="
      doGet('/admin/users/dashboard', 'rec', 'dashboard');
   ">
   <div class="" ng-init="rec.role = '<?=$authUser['user_role']?>'">
      <div class="page-title" style="padding: 10px;">
         <div class=" col-12 col-sm-6 col-md-6  side_div1">
            <h3><?= __('general_stat') ?></h3>
         </div>
         <div class=" col-12 col-sm-6 col-md-6 side_div2">
            <span class="icn">
               <?= $this->element('datePicker', ['from' => $from, 'to' => $to]) ?>
            </span>
            <?php  if(in_array($authUser['user_role'], ['admin.root']) || isset($authUser['user_original_role'])){?>
            <span class="icn">
               <?=$this->Form->control('role', [
                  'type'=>'select', 
                  'options'=>$this->Do->lcl( $this->Do->get('AdminRoles'), false, false ),
                  'label'=>false,
                  'class'=>'form-control',
                  'ng-model'=>'rec.role',
                  'ng-change'=>"doGet('/admin/configs/switch-role/'+rec.role)"
               ])?>
            </span>
            <?php }?>
         </div>
      </div>

      <div class="clearfix"></div>

      <div class="row">

         <div id="main_preloader" class="preloader col-12">
            <div>
               <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
            </div>
            <div><?= __('please_wait') ?></div>
         </div>

         <?php // NUMBERS   
         ?>
         <div class="col-12">
            <div class="">
               <?php //Properties 
               ?>
               <div class=" col-md-6 col-sm-6 col-12  tile_div">

                  <div class="notifications_div">
                     <a href="<?= $app_folder ?>/admin/properties<?= $authUser['user_role'] == 'admin.content' ? '' : '?from='.$authUser['stat_lastlogin'] ?>" ng-if="rec.dashboard.notifications.new_properties>0" class="badge badge-success noteItm">
                        <i class="fa fa-bell"></i> {{rec.dashboard.notifications.new_properties}} <?= __('new') ?>
                     </a>
                     <a href="<?= $app_folder ?>/admin/properties?stat_updated=0" ng-if="rec.dashboard.notifications.new_outdated_properties>0" class="badge badge-danger noteItm">
                        <i class="fa fa-retweet"></i> {{rec.dashboard.notifications.new_outdated_properties}} <?= __('outdated') ?>
                     </a>
                  </div>

                  <a href="<?= $app_folder ?>/admin/properties" class="tile_div_content">
                     <span class="count_top"><i class="fa fa-home"></i> <?= __('properties') ?></span>
                     <div class="count">
                        <ii>{{rec.dashboard.stats.numbers.total_active_properties}}</ii>/<small class="grayText">{{rec.dashboard.stats.numbers.total_inactive_properties}}</small>,
                        <ii class="greenText">{{rec.dashboard.stats.numbers.total_outdated_properties}}/<small class="redText">{{rec.dashboard.stats.numbers.total_updated_properties}}</small>
                     </div>
                     <span class="count_bottom"><?= __('active') ?>/
                     <span class="grayText"><?= __('inactive') ?>,
                        <span class="greenText"><?= __('updated') ?></span>/
                        <span class="redText"><?= __('outdated') ?></span>
                     </span>
                  </a>
               </div>

               <?php //Offices 
               if (in_array($authUser['user_role'], ['admin.admin', 'admin.root'])) {
               ?>
                  <div class=" col-md-3 col-sm-6 col-6 tile_div">
                     <a href="<?= $app_folder ?>/admin/offices" class="tile_div_content">
                        <span class="count_top"><i class="fa fa-briefcase"></i> <?= __('offices') ?></span>
                        <div class="count">
                           <ii>{{rec.dashboard.stats.numbers.total_offices}}</ii>
                        </div>
                        <span class="count_bottom"><?= __('total') ?>
                        </span>
                     </a>
                  </div>
               <?php } ?>

               <?php //Sellers 
               if (in_array($authUser['user_role'], ['admin.admin', 'admin.root', 'admin.supervisor'])) {
               ?>
                  <div class=" col-md-3 col-sm-6 col-6 tile_div">
                     <a href="<?= $app_folder ?>/admin/sellers" class="tile_div_content">
                        <span class="count_top"><i class="fa fa-handshake-o"></i> <?= __('sellers') ?></span>
                        <div class="count">
                           <ii>{{rec.dashboard.stats.numbers.total_sellers}}</ii>
                        </div>
                        <span class="count_bottom"><?= __('total') ?>
                        </span>
                     </a>
                  </div>
               <?php } ?>

               <?php //Projects 
               ?>
               <div class=" col-md-4 col-sm-6 col-6 tile_div">

                  <div class="notifications_div">
                     <a href="<?= $app_folder ?>/admin/projects<?= $authUser['user_role'] == 'admin.content' ? '' : '?from='.$authUser['stat_lastlogin'] ?>" ng-if="rec.dashboard.notifications.new_projects>0" class="badge badge-success noteItm">
                        <i class="fa fa-bell"></i> {{rec.dashboard.notifications.new_projects}} <?= __('new') ?>
                     </a>
                  </div>
                  
                  <a href="<?= $app_folder ?>/admin/projects" class="tile_div_content">
                     <span class="count_top"><i class="fa fa-building"></i> <?= __('projects') ?></span>
                     <div class="count">
                        <ii>{{rec.dashboard.stats.numbers.total_active_projects}}</ii>/
                        <small class="grayText">{{rec.dashboard.stats.numbers.total_inactive_projects}}</small>
                     </div>
                     <span class="count_bottom"><?= __('active') ?>/
                        <span class="grayText"><?= __('inactive') ?></span>
                     </span>
                  </a>
               </div>

               <?php //Developers 
               if (in_array($authUser['user_role'], ['admin.admin', 'admin.root', 'admin.portfolio', 'admin.supervisor'])) {
               ?>
                  <div class=" col-md-4 col-sm-6 col-6 tile_div">
                     <a href="<?= $app_folder ?>/admin/developers" class="tile_div_content">
                        <span class="count_top"><i class="fa fa-cubes"></i> <?= __('developers') ?></span>
                        <div class="count">
                           <ii>{{rec.dashboard.stats.numbers.total_developers}}</ii>
                        </div>
                        <span class="count_bottom"><?= __('total') ?>
                        </span>
                     </a>
                  </div>
               <?php } ?>

               <?php //Users 
               if (in_array($authUser['user_role'], ['admin.admin', 'admin.root'])) {
               ?>
                  <div class=" col-md-4 col-sm-6 col-6 tile_div">
                     <a href="<?= $app_folder ?>/admin/users" class="tile_div_content">
                        <span class="count_top"><i class="fa fa-user"></i> <?= __('users') ?></span>
                        <div class="count">
                           <ii>{{rec.dashboard.stats.numbers.total_enabled_users}}</ii>/
                           <small class="grayText">{{rec.dashboard.stats.numbers.total_disabled_users}}</small>
                        </div>
                        <span class="count_bottom"><?= __('active') ?>/
                           <span class="grayText"><?= __('inactive') ?></span>
                        </span>
                     </a>
                  </div>
               <?php } ?>

            </div>
         </div>
      </div>

      <div class="row">
         <?php // Prices blocks chart 
            if(in_array($authUser['user_role'], ['admin.admin', 'admin.root'])){
         ?>
         <div class="col-md-12 col-sm-12" id="priceBlocksChart">
            <div class="dashboard_graph">
               <div class="x_title row">
                  <div class="col-9">
                     <h3><?= __('properties_count') ?> - <small class="grayText"><?= __('per_price_range') ?></small></h3>
                  </div>
                  <div class="col-3 expand-icon">
                     <a href ng-click="toImage('#priceBlocksChart')">
                        <i class="fa fa-image"></i>
                     </a> &nbsp; &nbsp;
                     <a href ng-click="isExpanded.priceBlocksChart = !isExpanded.priceBlocksChart">
                        <i class="fa fa-{{isExpanded.priceBlocksChart ? 'compress' : 'expand'}}"></i>
                     </a>
                  </div>
               </div>
               <div class="{{!isExpanded.priceBlocksChart ? 'col-md-9 col-sm-9' : 'col-md-12 col-sm-12'}} ">
                  <div ng-if="rec.dashboard.stats.prices.values.length>0">
                     <canvas id="price_blocks_chart" set-chart='doughnut' dt='prices' unit='<?= __('properties') ?>'></canvas>
                  </div>
               </div>
               <div class="{{!isExpanded.priceBlocksChart ? 'col-md-3 col-sm-3' : 'col-md-12 col-sm-12'}}   bg-white h300" ng-ng-style="{{ !isExpanded.priceBlocksChart ? 'max-height: 400px; overflow: auto;' : '' }}">
                  <div class="x_title">
                     <h2><?= __('properties') ?></h2>
                     <div class="clearfix"></div>
                  </div>
                  <div ng-repeat="price in rec.dashboard.stats.prices.labels track by $index">
                     <p class="progress_item_title"><span>{{price}}</span>/ <span>{{ rec.dashboard.stats.prices.values[$index] }} <?= __('properties') ?></span></p>
                     <div class="progress progress_sm" style="width: 100%;">
                        <div class="progress-bar" set-progress-width="{{rec.dashboard.stats.prices.values.join(',')}}" ind="{{$index}}">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
         <?php } ?>


         <?php // Users roles count 
            if(in_array($authUser['user_role'], ['admin.admin', 'admin.root'])){
         ?>
         <div class="col-md-6 col-sm-12" id="userChart">
            <div class="dashboard_graph">
               <div class="x_title row">
                  <div class="col-9">
                     <h3><?= __('users') ?> - <small class="grayText"><?= __('user_role') ?></small></h3>
                  </div>
                  <div class="col-3 expand-icon">
                     <a href ng-click="toImage('#userChart')">
                        <i class="fa fa-image"></i>
                     </a> &nbsp; &nbsp;
                     <a href ng-click="isExpanded.userChart = !isExpanded.userChart">
                        <i class="fa fa-{{isExpanded.userChart ? 'compress' : 'expand'}}"></i>
                     </a>
                  </div>
               </div>
               <div class="{{!isExpanded.userChart ? 'col-md-9 col-sm-9' : 'col-md-12 col-sm-12'}} ">
                  <div ng-if="rec.dashboard.stats.users.items.length>0">
                     <canvas id="users_chart" set-chart='pie' dt='users'></canvas>
                  </div>
               </div>
               <div class="{{!isExpanded.userChart ? 'col-md-3 col-sm-3' : 'col-md-12 col-sm-12'}}   bg-white h300" ng-ng-style="{{ !isExpanded.userChart ? 'max-height: 400px; overflow: auto;' : '' }}">
                  <div class="x_title">
                     <h2><?= __('user_role') ?></h2>
                     <div class="clearfix"></div>
                  </div>
                  <div ng-repeat="user in rec.dashboard.stats.users.labels track by $index">
                     <p class="progress_item_title"><span>{{user}}</span>/ <span>{{ rec.dashboard.stats.users.values[$index] }} <?= __('user') ?></span></p>
                     <div class="progress progress_sm" style="width: 100%;">
                        <div class="progress-bar" set-progress-width="{{rec.dashboard.stats.users.values.join(',')}}" ind="{{$index}}">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
         <?php } ?>


         <?php // Users activities 
            if(in_array($authUser['user_role'], ['admin.admin', 'admin.root'])){
         ?>
         <div class="col-md-6 col-sm-12" id="userLoginsChart">
            <div class="dashboard_graph">
               <div class="x_title row">
                  <div class="col-9">
                     <h3><?= __('users') ?> - <small class="grayText"><?= __('users_activities') ?></small></h3>
                  </div>
                  <div class="col-3 expand-icon">
                     <a href ng-click="toImage('#userLoginsChart')">
                        <i class="fa fa-image"></i>
                     </a> &nbsp; &nbsp;
                     <a href ng-click="isExpanded.userLoginsChart = !isExpanded.userLoginsChart">
                        <i class="fa fa-{{isExpanded.userLoginsChart ? 'compress' : 'expand'}}"></i>
                     </a>
                  </div>
               </div>
               <div class="{{!isExpanded.userLoginsChart ? 'col-md-9 col-sm-9' : 'col-md-12 col-sm-12'}} ">
                  <div ng-if="rec.dashboard.stats.logins.items.length>0">
                     <canvas id="users_logins_chart" set-chart='doughnut' dt='logins' unit='<?= __('logins') ?>'></canvas>
                  </div>
               </div>
               <div class="{{!isExpanded.userLoginsChart ? 'col-md-3 col-sm-3' : 'col-md-12 col-sm-12'}}   bg-white h300" ng-ng-style="{{ !isExpanded.userLoginsChart ? 'max-height: 400px; overflow: auto;' : '' }}">
                  <div class="x_title">
                     <h2><?= __('users_activities') ?></h2>
                     <div class="clearfix"></div>
                  </div>
                  <div ng-repeat="user in rec.dashboard.stats.logins.labels track by $index">
                     <p class="progress_item_title"><span>{{user}}</span>/ <span>{{ rec.dashboard.stats.logins.values[$index] }} <?= __('logins') ?></span></p>
                     <div class="progress progress_sm" style="width: 100%;">
                        <div class="progress-bar" set-progress-width="{{rec.dashboard.stats.logins.values.join(',')}}" ind="{{$index}}">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
         <?php } ?>
      </div>


   </div>
</div>


<?php /* USERS ?>
   <div class="row" id="userChart">
      <div class="col-md-12 col-sm-12 ">
         <div class="dashboard_graph">
            <div class="x_title row">
               <div class="col-9">
                  <h3><?=__('users_daily_results')?> - <small class="grayText"><?=__('choco_piece')?></small></h3>
               </div>
               <div class="col-3 expand-icon">
                  <a href ng-click="toImage('#userChart')">
                     <i class="fa fa-image"></i>
                  </a> &nbsp; &nbsp;
                  <a href ng-click="isExpanded.userChart = !isExpanded.userChart">
                     <i class="fa fa-{{isExpanded.userChart ? 'compress' : 'expand'}}"></i>
                  </a>
               </div>
            </div>
            <div class="{{!isExpanded.userChart ? 'col-md-9 col-sm-9' : 'col-md-12 col-sm-12'}} ">
               <div ng-if="rec.dashboard.stats.users.items.length>0"> 
                  <canvas id="users_chart" set-chartxxxx='line' dt='users'></canvas> 
               </div>
            </div>
            <div class="{{!isExpanded.userChart ? 'col-md-3 col-sm-3' : 'col-md-12 col-sm-12'}}   bg-white" 
               ng-ng-style="{{ !isExpanded.userChart ? 'max-height: 400px; overflow: auto;' : '' }}">
               <div class="x_title">
                  <h2><?=__('users_total_results')?></h2>
                  <div class="clearfix"></div>
               </div>
               <div ng-repeat="user in rec.dashboard.stats.users.items">
                  <p class="progress_item_title"><span>{{user.label}}</span>/ <span>{{addSeperator( user.total_values )}} <?=__('piece')?></span></p>
                  <div class="progress progress_sm" style="width: 90%;">
                    <div class="progress-bar" ng-style="
                      width: {{ getPercentage( rec.dashboard.stats.users.items, user.total_values ) }}%;
                      background: {{clrs[$index]}}
                      "></div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>

   
   <?php // MACHINES ?>
   <div class="row" id="machineChart">
      <div class="col-md-12 col-sm-12 ">
         <div class="dashboard_graph">

            <div class="x_title row">
               <div class="col-9">
                  <h3><?=__('machines_chart_title')?></h3>
               </div>
               <div class="col-3 expand-icon">
                  <a href ng-click="toImage('#machineChart')">
                     <i class="fa fa-image"></i>
                  </a> &nbsp; &nbsp;
                  <a href ng-click="isExpanded.machineChart = !isExpanded.machineChart">
                     <i class="fa fa-{{isExpanded.machineChart ? 'compress' : 'expand'}}"></i>
                  </a>
               </div>
            </div>
            <div class="{{!isExpanded.machineChart ? 'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'}} ">               
               <div ng-if="rec.dashboard.stats.machines.items.length>0"> 
                  <canvas id="machines_chart" set-chart='pie' dt='machines'></canvas> 
               </div>
            </div>
            <div class="{{!isExpanded.machineChart ? 'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'}}  bg-white" 
               ng-style="{{ !isExpanded.machineChart ? 'max-height: 250px; overflow: auto;' : '' }}">
               <div class="x_title">
                  <h2><?=__('machines_total_results')?></h2>
                  <div class="clearfix"></div>
               </div>
               <div ng-repeat="machine in rec.dashboard.stats.machines.items">
                  <p class="progress_item_title"><span>{{machine.category_name}}</span>/ <span>{{addSeperator( machine.total_values )}} <?=__('piece')?></span></p>
                  <div class="progress progress_sm" style="width: 90%;">
                    <div class="progress-bar" ng-style="
                      width: {{ getPercentage( rec.dashboard.stats.machines.items, machine.total_values ) }}%;
                      background: {{clrs[$index]}}
                      "></div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>

   <?php // CHOCOTYPES ?>
   <div class="row" id="chocotypeChart">
      <div class="col-md-12 col-sm-12 ">
         <div class="dashboard_graph">
            <div class="x_title row">
               <div class="col-9">
                  <h3><?=__('chocotypes_chart_title')?></h3>
               </div>
               <div class="col-3 expand-icon">
                  <a href ng-click="toImage('#chocotypeChart')">
                     <i class="fa fa-image"></i>
                  </a> &nbsp; &nbsp;
                  <a href ng-click="isExpanded.chocotypeChart = !isExpanded.chocotypeChart">
                     <i class="fa fa-{{isExpanded.chocotypeChart ? 'compress' : 'expand'}}"></i>
                  </a>
               </div>
            </div>
            <div class="{{!isExpanded.chocotypeChart ? 'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'}} ">
               <!-- <canvas id="chocotypes_chart"></canvas> -->
               
               <div ng-if="rec.dashboard.stats.chocotypes.items.length>0">
                  <canvas id="chocotypes_chart" set-chartxxxx='pie' dt='chocotypes' unit="<?=__('kg')?>"></canvas> 
               </div>
            </div>
            <div class="{{!isExpanded.chocotypeChart ? 'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'}}  bg-white" ng-style="{{ !isExpanded.chocotypeChart ? 'max-height: 250px; overflow: auto;' : '' }}">
               <div class="x_title">
                  <h2><?=__('chocotypes_total_results')?></h2>
                  <div class="clearfix"></div>
               </div>
               <div ng-repeat="chocotype in rec.dashboard.stats.chocotypes.items">
                  <p class="progress_item_title">
                     <span>{{chocotype.category_name}}</span> / 
                     <span>{{addSeperator( chocotype.result_per_chocotype_kg )}} <?=__('kg')?></span>
                  </p>
                  <div class="progress progress_sm" style="width: 90%;">
                    <div class="progress-bar" ng-style="
                      width: {{ getPercentage( rec.dashboard.stats.chocotypes.items, chocotype.total_values ) }}%;
                      background: {{clrs[$index]}}
                      "></div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>


   <?php // RESULTS ?>
   <div class="row" id="resultChart">
      <div class="col-md-12 col-sm-12 ">
         <div class="dashboard_graph">
            <div class="x_panel2 ">

               <div class="x_title row">
                  <div class="col-9">
                     <h3><?=__('results_chart_title')?></h3>
                  </div>
                  <div class="col-3 expand-icon">
                     <a href ng-click="toImage('#resultChart')">
                        <i class="fa fa-image"></i>
                     </a>
                  </div>
               </div>

               <div class="x_content">       
                  <div ng-if="rec.dashboard.stats.results.items.length>0"> 
                     <canvas id="results_chart" set-chartxxxx='bar' dt='results'></canvas> 
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php */ ?>
</div>