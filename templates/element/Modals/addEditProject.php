<?php
$ctrl = $this->request->getParam('controller') == 'Properties' ? 'properties' : 'projects';
$isAdmin = in_array($authUser['user_role'], ['admin.supervisor', 'admin.admin', 'admin.root']);
?>


<div class="modal fade" id="addEditProject_mdl" tabindex="-1" role="dialog" aria-hidden="true" ng-init="'<?= $ctrl ?>' == 'projects' ? doGet('/admin/properties?cats=1', 'rec', 'projects') : '';">
    <div class="listing-modal-1 modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <div ng-if="!rec.project.id"><?= __('add_project') ?></div>
                    <div ng-if="rec.project.id"><?= __('edit_project') ?></div>
                </h4>
            </div>
            <div class="modal-body" id="accordion">

                <button type="button" id="project_btn" class="hideIt" ng-click="
                    '<?= $ctrl ?>' == 'properties' ? doGet('/admin/properties?cats=1', 'rec', 'projects') : '';
                    '<?= $ctrl ?>' == 'projects' ? do_NOT_Get('/admin/projects?list=1', 'list', 'projects') : '';
                    doGet('/admin/projects?id='+rec.project.id, 'rec', 'project');
                    filesInfo.project_photos=[];
                    filesInfo.floorplan_photo=[];
                    rec.floorplan = {};
                    getProjectLoc(rec.project.id);
                ">
                </button>

                <form class="row" id="project_form" ng-submit="
                    rec.project.img = filesInfo.project_photos;
                    rec.project.isModal = '1';
                    doSave(rec.project, 'project', 'projects',  '#project_btn', '#project_preloader'); ">

                    <div id="project_preloader" class="preloader">
                        <div>
                            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                        </div>
                        <div><?= __('please_wait') ?></div>
                    </div>

                    <!-- STEP 2 Map -->
                    <div class="col-md-12 col-sm-12">
                        <div class="xxx_title accordion_header" data-toggle="collapse" data-target="#step2">
                            <h2><i class="fa fa-building"></i> <?= __('project_info_sec') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="xxx_content row fade collapse show" id="step2" data-parent="#accordion">
                            <div class="col-md-12 has-feedback">
                                <label><?= __('search_in_map') ?></label>
                                <div class="div">
                                    <input type="text" placeholder="<?= __('find_address') ?>" class="form-control has-feedback-left" id="mapPlacesSearch_mdl" />
                                    <span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-md-8 col-8 has-feedback">
                                <label><?= __('search_by_coords') ?></label>
                                <div class="div">
                                    <input type="text" placeholder="Ex: 41.056881,28.990970, or Google map link" class="form-control has-feedback-left" ng-model="mapCoords" />
                                    <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <label>&nbsp;</label>
                                <div class="div">
                                    <button class="btn btn-primary w100" type="button" ng-click="getLatLng(mapCoords, 'map_mdl')"><?= __('find') ?></button>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div id="map-canvas_mdl" loc="rec.project.project_loc" class="map_div"></div>
                            </div>

                            <div class="col-md-12 mt-1">
                                <button class="btn btn-primary w100" type="button" ng-click="getLoc('map_mdl', 'project')" id="getLoc_loader"><span></span> <i class="fa fa-thumb-tack"></i> <?= __('get_your_current_location') ?></button>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 mb-2 mt-2">
                                <div class="row dashed-btn-line">
                                    <div class="col-5 col-sm-3"><b set-required><?= __('adrs_country') ?></b></div>
                                    <div class="col-7 col-sm-9"> {{rec.project.adrs_country}}</div>
                                    <div class="col-5 col-sm-3"><b set-required><?= __('adrs_city') ?></b></div>
                                    <div class="col-7 col-sm-9"> {{rec.project.adrs_city}}</div>
                                    <div class="col-5 col-sm-3"><b set-required><?= __('adrs_region') ?></b></div>
                                    <div class="col-7 col-sm-9"> {{rec.project.adrs_region}}</div>
                                    <div class="col-5 col-sm-3"><b><?= __('adrs_district') ?></b></div>
                                    <div class="col-7 col-sm-9"> {{rec.project.adrs_district}}</div>
                                    <div class="col-5 col-sm-3"><b><?= __('adrs_street') ?></b></div>
                                    <div class="col-7 col-sm-9"> {{rec.project.adrs_street}}</div>
                                    <div class="col-5 col-sm-3"><b set-required name="project_loc"><?= __('project_loc') ?></b></div>
                                    <div class="col-7 col-sm-9"> {{rec.project.project_loc}}</div>
                                </div>
                            </div>


                            <hr class="clearfix col-md-12 col-sm-12 row " />

                            <div class="col-md-8 col-sm-8  form-group has-feedback">
                                <label set-required><?= __('project_title') ?></label>
                                <div class="div">
                                    <?= $this->Form->control('project_title', [
                                        'class' => 'form-control has-feedback-left',
                                        'label' => false,
                                        'type' => 'text',
                                        'ng-model' => 'rec.project.project_title'
                                    ]) ?>
                                    <span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <?php /*?>
                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label><?= __('language_id') ?></label>
                                <div class="div">
                                <?= $this->Form->control('language_id', [
                                    'class' => 'form-control has-feedback-left',
                                    'label' => false,
                                    'type' => 'select',
                                    'ng-model' => 'rec.project.language_id',
                                    'options' => $this->Do->lcl($this->Do->get('langs'))
                                ]) ?>
                                <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <?Php */ ?>

                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label set-required><?= __('category_id') ?></label>
                                <div class="div">
                                    <?= $this->Form->control('category_id', [
                                        'options' => $this->Do->lcl($this->Do->cat('PROJ_CATEGORIES')),
                                        'class' => 'form-control has-feedback-left',
                                        'label' => false,
                                        'type' => 'select',
                                        'ng-model' => 'rec.project.category_id'
                                    ]) ?>
                                    <span class="fa fa-bars form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label><?= __('developer_id') ?></label>
                                <div class="div">
                                    <?=$this->Form->control('', [
                                        'type'=>'select',
                                        'options'=>$developers,
                                        'class'=>'selectpicker form-control ',
                                        'data-live-search'=>'true',
                                        'data-size'=>'4',
                                        'empty'=>__('select_developer'),
                                        'ng-model'=>'rec.project.developer_id',
                                        'multi-select'=>'false'
                                    ])?>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6  form-group has-feedback">
                                <label><?= __('seller_id') ?></label>
                                <div class="div">
                                    <?=$this->Form->control('', [
                                        'type'=>'select',
                                        'options'=>$sellers,
                                        'class'=>' form-control has-feedback-left ',
                                        'label' => false,
                                        'empty'=>__('select_developer'),
                                        'ng-model'=>'rec.project.seller_id'
                                    ])?>
                                    <span class="fa fa-handshake-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6  form-group has-feedback" ng-if="rec.project.project_ref">
                                <label><?= __('project_ref') ?></label>
                                <div class="div">
                                    <?= $this->Form->control('project_ref', [
                                        'class' => 'form-control has-feedback-left',
                                        'label' => false,
                                        'type' => 'text',
                                        'ng-disabled' => "!isDisabled['project_ref']",
                                        'ng-model' => 'rec.project.project_ref',
                                    ]) ?>
                                    <span class="fa fa-anchor form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <a href class="btn btn-info btn-sm float-btn" ng-show="!isDisabled['project_ref']" ng-click="
                                        isDisabled['project_ref']=true;">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>

                            <hr class="clearfix col-md-12 col-sm-12 row " />

                            
                            <!-- Payment plan -->
                            <?php echo $this->element('Includes/payment_plan')?>


                            <div class="clearfix"></div>

                            <div class="col-md-12 col-12 ">
                                <button type="submit" id="project_preloader" class="btn btn-info">
                                    <span></span> <i class="fa fa-save"></i> <?= __('save') ?>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- STEP 3 Specs -->
                    <div class="col-md-12 col-sm-12" ng-show="rec.project.id>0">
                        <div class="xxx_title accordion_header" data-toggle="collapse" data-target="#step3" id="step3_btn">
                            <h2><i class="fa fa-asterisk"></i> <?= __('project_specs_sec') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="xxx_content fade collapse " id="step3" data-parent="#accordion">

                            <div class="row  form-group has-feedback">
                                <?php foreach ($this->Do->cat('PROJ_SPECS.main') as $k => $spec) {
                                    $list = $this->Do->cat('PROJ_SPECS.' . $k);
                                    $type = 'select';
                                    $isDatePicker = $spec == 'param_deliverdate' ? 1 : 0;
                                    $icn = 'info-circle';
                                    if ($spec == 'param_deliverdate') {
                                        $icn = 'calendar';
                                    }
                                    if (!is_array($list)) {
                                        $type = 'text';
                                    }
                                    if (!in_array($spec, ['param_unit_types', 'param_units_size_range', 'param_iscitizenship', 'param_isresidence'])) {
                                ?>

                                        <div class="col-lg-4 col-md-6  form-group has-feedback">
                                            <label><?= __($spec) ?></label>
                                            <div class="div">
                                                <?= $this->Form->control($spec, [
                                                    'class' => 'form-control has-feedback-left',
                                                    'label' => false,
                                                    'type' => $type,
                                                    'ng-model' => 'rec.project.' . $spec,
                                                    'options' => in_array($type, ['checkbox', 'select']) ? $this->Do->lcl($list) : false,
                                                    'date-picker' => $isDatePicker ? 'onlyMonthYear' : false,
                                                    'isModal' => '#addEditProject',
                                                    'initval' => '{{rec.project.' . $spec . '}}',
                                                ]) ?>
                                                <span class="fa fa-<?= $icn ?> form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                    <?php } elseif ($spec == 'param_unit_types') { ?>

                                        <div class="col-lg-4 col-md-6  form-group has-feedback">
                                            <label><?= __($spec) ?></label>
                                            <div class="div">
                                                <?= $this->Form->control($spec, [
                                                    'class' => 'form-control selectpicker', //has-feedback-left
                                                    'label' => false,
                                                    'type' => 'select',
                                                    'multiple' => true,
                                                    'multi-select' => true,
                                                    'empty' => true,
                                                    'ng-model' => 'rec.project.' . $spec,
                                                    'options' => $this->Do->lcl($list),
                                                    // 'data-done-button'=>true,  
                                                    // 'data-live-search'=>true,
                                                ]) ?>
                                                <!-- <span class="fa fa-info-circle form-control-feedback left" aria-hidden="true"></span> -->
                                            </div>
                                        </div>
                                        
                                    <?php } elseif ($spec == 'param_units_size_range') { ?>

                                        <div class="col-lg-6 col-md-6  form-group has-feedback">
                                            <label><?= __($spec) ?></label>
                                            <div set-slider="" _fromto="{{rec.project.param_units_size_range}}" end="500" unit="<?= __('m2') ?>" step="1" tar="project.param_units_size_range"></div>

                                            <div class="fromToDiv">
                                                <b><?= __('from') ?></b>
                                                <span><input type="text" only-numbers=""  mask-currency="false" config="{group:'.',decimal:'.', decimalSize: 0,indentation:''}" ng-model="rec.project.<?= $spec ?>[0]"> <?= __('m2') ?> </span>
                                                <b><?= __('to') ?></b>
                                                <span><input type="text" only-numbers=""  mask-currency="false" config="{group:'.',decimal:'.', decimalSize: 0,indentation:''}" ng-model="rec.project.<?= $spec ?>[1]"> <?= __('m2') ?> </span>

                                                <?php /* <span> <button ng-click="doClick('#submit_btn')" class="small-btn"><?=__('go')?></button></span> -->
                                                    <!-- <b><?= __('from') ?></b>
                                                    <span>{{nFormat( rec.project.<?= $spec ?>[0] ,'<?= __('m2') ?>')}}</span>
                                                    <b><?= __('to') ?></b>
                                                    <span>{{nFormat( rec.project.<?= $spec ?>[1] ,'<?= __('m2') ?>')}}</span> <?php */ ?>
                                            </div>
                                        </div>
                                    <?php } elseif (in_array($spec, ['param_iscitizenship', 'param_isresidence'])) { ?>
                                        
                                        <div class="col-md-6 col-sm-6 form-group has-feedback">
                                            <label dont-set-required><?=__($spec)?></label>
                                            <div class="div specsRadioBtn">
                                                <label class="myradiobtn">
                                                    <input type="radio" ng-model="rec.project.<?=$spec?>" name="<?=$spec?>" value="1"/> <span></span> <?=__('yes')?> 
                                                </label>&nbsp;
                                                <label class="myradiobtn">
                                                    <input type="radio" ng-model="rec.project.<?=$spec?>" name="<?=$spec?>" value="0"/> <span></span> <?=__('no')?> 
                                                </label>
                                            </div>
                                        </div>

                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 col-12 ">
                                <button type="submit" id="project_preloader" class="btn btn-info">
                                    <span></span> <i class="fa fa-save"></i> <?= __('save') ?>
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- STEP 4 Features -->
                    <div class="col-md-12 col-sm-12" ng-if="rec.project.id>0">
                        <a class="xxx_title accordion_header" data-toggle="collapse" data-target="#step4">
                            <h2><i class="fa fa-file-text-o"></i> <?= __('project_features_sec') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </a>

                        <div class="xxx_content fade collapse" id="step4" data-parent="#accordion">

                            <?php foreach ($this->Do->cat('PROJ_FEATURES.main') as $k => $group) { ?>

                                <div class="">
                                    <b><?= __($group) ?></b>
                                </div>
                                <?php foreach ($this->Do->cat('PROJ_FEATURES.' . $k) as $k2 => $feature) { ?>

                                    <div class="col-lg-3 col-sm-4 col-6 ">
                                        <label class="mycheckbox">
                                            <?= $this->Form->control($feature, [
                                                'class' => 'form-control ',
                                                'label' => false,
                                                'type' => 'checkbox',
                                                'ng-model' => 'rec.project.features_ids[' . $k2 . ']',
                                                'ng-value' => $k2,
                                                'templates' => [
                                                    'inputContainer' => '{{content}}'
                                                ]
                                            ]) ?>
                                            <span></span>&nbsp;<span class="chkbox_text"><?= __($feature) ?></span>
                                        </label>
                                    </div>

                                <?php } ?>

                                <div class="clearfix mb-5"></div>
                            <?php } ?>

                            <div class="clearfix"></div>

                            <div class="col-md-12 col-12 ">
                                <button type="submit" id="project_preloader" class="btn btn-info">
                                    <span></span> <i class="fa fa-save"></i> <?= __('save') ?>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- STEP 5 Photos and Videos -->
                    <div class="col-md-12 col-sm-12" ng-if="rec.project.id>0">
                        <a class="xxx_title accordion_header" data-toggle="collapse" data-target="#step5">
                            <h2><i class="fa fa-camera"></i> <?= __('project_photos') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </a>

                        <div class="xxx_content fade collapse" id="step5" data-parent="#accordion">

                            <div class="col-md-12 col-12 mt-5 mb-5">
                                <label class="big-icon">
                                    <span>
                                        <i class="fa fa-picture-o"></i> <?= __("add_photos") ?>
                                        <?= $this->Form->control('project_photos', [
                                            'class' => 'form-control hideIt', 'type' => 'file',
                                            'file-model' => 'files.project_photos', 'multiple' => true,
                                            'ng-model' => 'rec.project.project_photos',
                                            'id' => 'project', 'label' => false,
                                            'accept' => '.png,.jpeg,.jpg',
                                        ]) ?>
                                    </span>
                                    <?php /*?>
                                    <span class="hideWebInline">
                                        <a href="" ng-click="openCamera(); currTab = 'take_photo'; ">
                                        <i class="fa fa-camera"></i> <?= __("open_camera") ?>
                                        </a>
                                    </span>
                                    <?php */ ?>
                                </label>

                                <div class="img_thumb">
                                    <span ng-repeat="img in rec.project.project_photos track by $index" class="img">
                                        <a href class="overly_btn" ng-click="
                                            delImage('/admin/projects/delimage/'+rec.project.id,{image: img, id: rec.project.id}, '#project_btn')">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <img show-img="" ng-src="{{getPhoto( img.tmp_name, img, 'projects')}}" alt="">
                                    </span>

                                    <span ng-repeat="img in filesInfo.project_photos track by $index" class="img">
                                        <a href class="overly_btn" ng-click="
                                            filesInfo.project_photos.splice($index, 1);">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <img show-img="" ng-src="{{getPhoto( img.tmp_name, img, 'projects' )}}" alt="" class="newImg">
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12  form-group has-feedback">
                                <label><?= __('project_videos') ?></label>
                                <div class="div form-control">
                                    <i><?= __('upload_videos_desc') ?></i>
                                    <?= $this->element("tagInput-ng", ["ng" => "rec.project.project_videos", "placeholder" => __("property_videos_ph")]); ?>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 col-12 ">
                                <button type="submit" id="project_preloader" class="btn btn-info">
                                    <span></span> <i class="fa fa-save"></i> <?= __('save') ?>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- STEP 6 Floorplans -->
                    <div class="col-md-12 col-sm-12" ng-if="rec.project.id>0" id="floorplan_form">
                        <a class="xxx_title accordion_header" data-toggle="collapse" data-target="#step6">
                            <h2><i class="fa fa-sitemap"></i> <?= __('project_floorplans') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </a>
                        <div class="xxx_content fade collapse" id="step6" data-parent="#accordion">

                            <?php echo $this->element('Includes/floorplans')?>

                        </div>
                    </div>

                    <!-- STEP 7 Descriptions -->
                    <div class="col-md-12 col-sm-12" ng-if="rec.project.id>0">
                        <a class="xxx_title accordion_header" data-toggle="collapse" data-target="#step7">
                            <h2><i class="fa fa-info-circle"></i> <?= __('project_desc') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </a>

                        <div class="xxx_content fade collapse row" id="step7" data-parent="#accordion">

                            <div class="col-md-12 col-sm-12  form-group has-feedback">
                                <label><?= __('project_desc') ?></label>
                                <div class="div">
                                    <?= $this->Form->control('project_desc', [
                                        'class' => 'form-control has-feedback-left',
                                        'label' => false,
                                        'type' => 'textarea',
                                        'ckeditor' => 'ckoptions',
                                        'ng-model' => 'rec.project.project_desc'
                                    ]) ?>
                                    <span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12 col-12 ">
                                <button type="submit" id="project_preloader" class="btn btn-info">
                                    <span></span> <i class="fa fa-save"></i> <?= __('save') ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    
                    <?php // STEP 8 Upload Docoments 
                            ?>
                    <?php if($isAdmin){?>
                    <div class="col-md-12 col-sm-12" ng-if="rec.project.id>0" id="docs">
                        <a class="xxx_title accordion_header" data-toggle="collapse" data-target="#step8">
                            <h2><i class="fa fa-file"></i> <?= __('docs') ?> <span class="fa fa-caret-down"></span></h2>
                            <div class="clearfix"></div>
                        </a>

                        <div class="xxx_content fade collapse " id="step8" data-parent="#accordion">
                            <?php echo $this->element('Includes/docs');?>
                        </div>
                    </div>
                    <?php }?>

                </form>

            </div>
        </div>
    </div>
</div>