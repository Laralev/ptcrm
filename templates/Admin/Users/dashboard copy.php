
<?php
switch( $authUser['user_role'] ){
    case "user.admin":
        $floatBadge = [
            'exams'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.exams_new>0"
                title="'.__('exams_new').'">{{lists.stats.numbers.exams_new}}</a>', 
            'homeworks'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.homeworks_new>0"
                title="'.__('homeworks_new').'">{{lists.stats.numbers.homeworks_new}}</a>',
            'students'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.students_new>0"
            title="'.__('students_new').'">{{lists.stats.numbers.students_new}}</a>'
        ];
        break;
    case "user.teacher":
        $floatBadge = [
            'exams'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.exams_solved>0"
                title="'.__('exams_solved').'">{{lists.stats.numbers.exams_solved}}</a>', 
            'homeworks'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.homeworks_solved>0"
                title="'.__('homeworks_solved').'">{{lists.stats.numbers.homeworks_solved}}</a>',
            'students'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.students_new>0"
            title="'.__('students_new').'">{{lists.stats.numbers.students_new}}</a>'
        ];
        break;
    case "user.student":
        $floatBadge = [
            'exams'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.exams_assigned>0"
                title="'.__('exams_assigned').'">{{lists.stats.numbers.exams_assigned}}</a>', 
            'homeworks'=>'<a href="javascript:void(0);" class="badge badge-sm badge-danger badge-float"  ng-if="lists.stats.numbers.homeworks_assigned>0"
                title="'.__('homeworks_assigned').'">{{lists.stats.numbers.homeworks_assigned}}</a>',
            'students'=>''
        ];
        break;
    default :
    $floatBadge = ['exams'=>'', 'homeworks'=>'', 'students'=>''];
}
// $tasks = [
//     'items' => [
//         [
//             'text' => __('create_new_account'),
//             'url' => '',
//             'stat' => 1,
//             'roles' => []
//         ],
//         [
//             'text' => __('activate_account'),
//             'url' => '',
//             'stat' => $authUser['rec_state'],
//             'roles' => []
//         ],
//         [
//             'text' => __('create_categories'),
//             'url' => '/categories?hint=create',
//             'stat' => $stats['categories'],
//             'roles' => ['user.teacher', 'user.student']
//         ],
//         [
//             'text' => __('create_homework_or_exam'),
//             'url' => ($stats['homeworks']>$stats['exams'] ? '/exams' : '/homeworks').'?hint=create',
//             'stat' => $stats['exams'] + $stats['homeworks'],
//             'roles' => ['user.student']
//         ],
//         [
//             'text' => __('create_student'),
//             'url' => '/students?hint=create',
//             'stat' => $stats['students'],
//             'roles' => ['user.student']
//         ],
//         [
//             'text' => __('create_teacher'),
//             'url' => '/teachers?hint=create',
//             'stat' => $stats['teachers'],
//             'roles' => [
//                 'user.student',
//                 'user.teacher'
//             ]
//         ],
//         [
//             'text' => __('create_room'),
//             'url' => '/rooms?hint=create',
//             'stat' => $stats['rooms'],
//             'roles' => [
//                 'user.student',
//                 'user.teacher'
//             ]
//         ],
//         [
//             'text' => __('add_student_to_room'),
//             'url' => '/students?hint=attach',
//             'stat' => $stats['students_rooms'],
//             'roles' => ['user.student']
//         ],
//         [
//             'text' => __('add_teacher_to_room'),
//             'url' => '/teachers?hint=attach',
//             'stat' => $stats['teachers_rooms'],
//             'roles' => [
//                 'user.student',
//                 'user.teacher'
//             ]
//         ],
//         [
//             'text' => __('send_homework_or_exam_to_students'),
//             'url' => ($stats['students_homeworks']>$stats['students_exams'] ? '/exams' : '/homeworks').'?hint=assign',
//             'stat' => $stats['students_exams'] + $stats['students_homeworks'],
//             'roles' => ['user.student']
//         ],
//         [
//             'text' => __('check_sent_homework_status'),
//             'url' => ($stats['students_homeworks']>$stats['students_exams'] ? '/exams' : '/homeworks').'?hint=check',
//             'stat' =>  $stats['students_exams'] + $stats['students_homeworks'],
//             'roles' => ['user.student']
//         ],
//     ],
//     'status' => $stats['status']
// ];
// debug($stats );
?>


<!--My Order Content -->
<?php //echo $this->element("whereIm") ?>

<?php
   $from = !isset($_GET['from']) ? date('Y-m-d' ,strtotime('first day of this month')) : $_GET['from'];
   $to = !isset($_GET['to']) ? date('Y-m-d') : $_GET['to'];
   ?>

<div class="right_col" role="main" ng-init="doGet('/admin/configs/statistics', 'rec', 'stats')">
   <div >

      <div class="col-12">
         <h1> <?=__('general_stat')?> </h1>
      </div>

      <div class="col-12 text-center">
         <h2> <?=__('date')?> <?=$this->element('datePicker', ['from'=>$from, 'to'=>$to])?> </h2>
         <hr>
      </div>
      
      <?php // NUMBERS   ?>
      <div class="col-12">
         <div class="row tile_count">

            <?php //Users ?>
            <div class=" col-md-4 col-sm-6 col-12  tile_stats_count">
               <span class="count_top"><i class="fa fa-user"></i> <?=__('total_users')?></span>
               <div class="count">
                  <ii>{{rec.stats.numbers.total_active_users}}</ii>/
                  <small class="grayText">{{rec.stats.numbers.total_inactive_users}}</small>
               </div>
               <span class="count_bottom"><?=__('active')?>/
                  <span class="grayText"><?=__('inactive')?></span>
               </span>
            </div>
            
            <?php //Properties ?>
            <div class=" col-md-4 col-sm-6 col-12  tile_stats_count">
               <span class="count_top"><i class="fa fa-home"></i> <?=__('total_properties')?></span>
               <div class="count">
                  <ii>{{rec.stats.numbers.total_inactive_properties}}</ii>/
                  <small class="greenText">{{rec.stats.numbers.total_updated_properties}}</small>/
                  <small class="redText">{{rec.stats.numbers.total_outdated_properties}}</small>
               </div>
               <span class="count_bottom"><?=__('active')?>/
                  <span class="greenText"><?=__('updated')?></span>/
                  <span class="redText"><?=__('outdated')?></span>
               </span>
            </div>
            
            <?php //Projects ?>
            <div class=" col-md-2 col-sm-6 col-12  tile_stats_count">
               <span class="count_top"><i class="fa fa-building"></i> <?=__('total_projects')?></span>
               <div class="count">
                  <ii>{{rec.stats.numbers.total_active_projects}}</ii>/
                  <small class="grayText">{{rec.stats.numbers.total_inactive_projects}}</small>
               </div>
               <span class="count_bottom"><?=__('active')?>/
                  <span class="grayText"><?=__('inactive')?></span>
               </span>
            </div>
            
            <?php //Sellers ?>
            <div class=" col-md-2 col-sm-6 col-12  tile_stats_count">
               <span class="count_top"><i class="fa fa-handshake-o"></i> <?=__('total_sellers')?></span>
               <div class="count">
                  <ii>{{rec.stats.numbers.total_sellers}}</ii>
               </div>
               <span class="count_bottom"><?=__('total')?>
               </span>
            </div>
            
            <?php //Developers ?>
            <div class=" col-md-2 col-sm-6 col-12  tile_stats_count">
               <span class="count_top"><i class="fa fa-cubes"></i> <?=__('total_developers')?></span>
               <div class="count">
                  <ii>{{rec.stats.numbers.total_developers}}</ii>
               </div>
               <span class="count_bottom"><?=__('total')?>
               </span>
            </div>
            
            <?php //Offices ?>
            <div class=" col-md-2 col-sm-6 col-12  tile_stats_count">
               <span class="count_top"><i class="fa fa-briefcase"></i> <?=__('total_offices')?></span>
               <div class="count">
                  <ii>{{rec.stats.numbers.total_offices}}</ii>
               </div>
               <span class="count_bottom"><?=__('total')?>
               </span>
            </div>
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
               <div ng-if="rec.stats.users.items.length>0"> 
                  <canvas id="users_chart" set-chartxxxx='line' dt='users'></canvas> 
               </div>
            </div>
            <div class="{{!isExpanded.userChart ? 'col-md-3 col-sm-3' : 'col-md-12 col-sm-12'}}   bg-white" 
               ng-ng-style="{{ !isExpanded.userChart ? 'max-height: 400px; overflow: auto;' : '' }}">
               <div class="x_title">
                  <h2><?=__('users_total_results')?></h2>
                  <div class="clearfix"></div>
               </div>
               <div ng-repeat="user in rec.stats.users.items">
                  <p class="progress_item_title"><span>{{user.label}}</span>/ <span>{{addSeperator( user.total_values )}} <?=__('piece')?></span></p>
                  <div class="progress progress_sm" style="width: 90%;">
                    <div class="progress-bar" ng-style="
                      width: {{ getPercentage( rec.stats.users.items, user.total_values ) }}%;
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
               <div ng-if="rec.stats.machines.items.length>0"> 
                  <canvas id="machines_chart" set-chart='pie' dt='machines'></canvas> 
               </div>
            </div>
            <div class="{{!isExpanded.machineChart ? 'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'}}  bg-white" 
               ng-style="{{ !isExpanded.machineChart ? 'max-height: 250px; overflow: auto;' : '' }}">
               <div class="x_title">
                  <h2><?=__('machines_total_results')?></h2>
                  <div class="clearfix"></div>
               </div>
               <div ng-repeat="machine in rec.stats.machines.items">
                  <p class="progress_item_title"><span>{{machine.category_name}}</span>/ <span>{{addSeperator( machine.total_values )}} <?=__('piece')?></span></p>
                  <div class="progress progress_sm" style="width: 90%;">
                    <div class="progress-bar" ng-style="
                      width: {{ getPercentage( rec.stats.machines.items, machine.total_values ) }}%;
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
               
               <div ng-if="rec.stats.chocotypes.items.length>0">
                  <canvas id="chocotypes_chart" set-chartxxxx='pie' dt='chocotypes' unit="<?=__('kg')?>"></canvas> 
               </div>
            </div>
            <div class="{{!isExpanded.chocotypeChart ? 'col-md-6 col-sm-6' : 'col-md-12 col-sm-12'}}  bg-white" ng-style="{{ !isExpanded.chocotypeChart ? 'max-height: 250px; overflow: auto;' : '' }}">
               <div class="x_title">
                  <h2><?=__('chocotypes_total_results')?></h2>
                  <div class="clearfix"></div>
               </div>
               <div ng-repeat="chocotype in rec.stats.chocotypes.items">
                  <p class="progress_item_title">
                     <span>{{chocotype.category_name}}</span> / 
                     <span>{{addSeperator( chocotype.result_per_chocotype_kg )}} <?=__('kg')?></span>
                  </p>
                  <div class="progress progress_sm" style="width: 90%;">
                    <div class="progress-bar" ng-style="
                      width: {{ getPercentage( rec.stats.chocotypes.items, chocotype.total_values ) }}%;
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
                  <div ng-if="rec.stats.results.items.length>0"> 
                     <canvas id="results_chart" set-chartxxxx='bar' dt='results'></canvas> 
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php */?>
</div>
