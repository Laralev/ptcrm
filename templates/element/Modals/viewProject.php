<?php
    $is_offer = in_array($authUser['user_role'], ['admin.callcenter', 'admin.root', 'admin.admin', 'admin.supervisor']);
?>  

<div class="modal fade" id="viewProject_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?= __('view_project') ?>
                </h4>
            </div>

            <div class="modal-body">

                <div class="">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <?php // Nav tabs ?>
                            <div class="bar-btns">
                                <a href ng-click="curr_t = 'main'" ng-class="{active: curr_t == 'main' }" class="small-btn"><?=__('project')?></a>
                                <a href ng-click="curr_t = 'floorplans'" ng-class="{active: curr_t == 'floorplans' }" class="small-btn"><?=__('floorplans')?></a>
                                <a href ng-click="curr_t = 'properties'" ng-class="{active: curr_t == 'properties' }" class="small-btn"><?=__('properties')?></a>
                                <?php if($is_offer){?>
                                <a href ng-click="curr_t = 'proposals';" ng-class="{active: curr_t == 'proposals' }" class="small-btn"><?=__('proposals')?></a>
                                <?php }?>
                            </div>

                            <div class="view_page tab-content">

                                <?php // Project ?>
                                <div ng-show="curr_t == 'main'" class="grid">
                                    <div class="grid_row row">
                                        <h4 class="col-12">
                                            <span class="badge badge-info">{{rec.project.project_ref}}</span> 
                                            <span class="badge badge-warning">{{DtSetter( 'PROJ_CATEGORIES', rec.project.category_id )}}</span> 
                                            {{rec.project.project_title}}
                                        </h4>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('features_ids')?></div>
                                        <div class="col-md-9 notwrapped"> <span class="badge badge-warning" 
                                            ng-repeat="(k, itm) in rec.project.features_ids track by $index" 
                                            style="margin: 0 2px;">{{DtSetter('PROJ_FEATURES', k)}}</span> 
                                        </div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('project_photos')?></div>
                                        <div class="col-md-9 notwrapped">
                                            <span class="thumb-img" ng-repeat="img in rec.project.project_photos track by $index">
                                                <img ng-src="<?=$app_folder?>/img/projects_photos/thumb/{{img}}" style="height:70px"
                                                    show-img="{{rec.project.project_photos.join(',')}}" curr="{{img}}" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('project_videos')?></div>
                                        <div class="col-md-9 notwrapped">
                                            <div class="row">
                                                <div class="col-md-6" ng-repeat="vid in rec.project.project_videos track by $index" set-iframe="{{vid}}">
                                                    <!-- Here iframe vidoes will be included -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('project_desc')?></div>
                                        <div class="col-md-9 notwrapped" ng-bind-html="rec.project.project_desc"></div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('project_loc')?></div>
                                        <div class="col-md-9 notwrapped">
                                            <div class='gmapImg'>
                                                <img style='max-width:600px' show-img="" ng-src='https://maps.googleapis.com/maps/api/staticmap?center={{rec.project.project_loc}}&zoom=10&size=600x300&maptype=roadmap&markers=color:green%7Clabel:S%7C{{rec.project.project_loc}}&key=<?=$gmapKey?>'/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('address')?></div>
                                        <div class="col-md-9 notwrapped">
                                            {{DtSetter('COUNTRIERS_CATEGORIES', rec.project.adrs_country)}}/
                                            {{DtSetter('COUNTRIERS_CATEGORIES', rec.project.adrs_city)}}/
                                            {{DtSetter('COUNTRIERS_CATEGORIES', rec.project.adrs_region)}}/
                                            {{DtSetter('COUNTRIERS_CATEGORIES', rec.project.adrs_district)}}
                                        </div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('param_space')?></div>
                                        <div class="col-md-9 notwrapped">{{nFormat( rec.project.param_space )}} <?=__('m2')?></div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('param_delivertype')?></div>
                                        <div class="col-md-9 notwrapped">{{ DtSetter('PROJ_SPECS', rec.project.param_delivertype) }}</div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('param_deliverdate')?></div>
                                        <div class="col-md-9 notwrapped">{{ rec.project.param_deliverdate }}</div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('stat_created')?></div>
                                        <div class="col-md-9 notwrapped">{{ rec.project.stat_created }}</div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('stat_updated')?></div>
                                        <div class="col-md-9 notwrapped">{{ rec.project.stat_updated }}</div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('stat_views')?></div>
                                        <div class="col-md-9 notwrapped">{{ rec.project.stat_views }}</div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('stat_shares')?></div>
                                        <div class="col-md-9 notwrapped">{{ rec.project.stat_shares }}</div>
                                    </div>
                                    <div class="grid_row row">
                                        <div class="col-md-3 grid_header2"><?=__('rec_state')?></div>
                                        <div class="col-md-9 notwrapped" ng-bind-html="DtSetter('bool2', rec.project.rec_state)"></div>
                                    </div>
                                </div>
                                
                                <?php // Floorplans  ?>
                                <div ng-show="curr_t == 'floorplans'" class="grid">
                                    <div class="row">
                                        <table class="table">
                                            <tr ng-repeat="fp in rec.project.floorplans" class="grid_row">
                                                <td> 
                                                    <img ng-src="{{getPhoto(false, fp.floorplan_photo, 'floorplans')}}" show-img style="max-height:90px"/>
                                                    <b>{{fp.floorplan_name}}</b>
                                                </td>
                                                <td>
                                                    {{fp.floorplan_minsize}}<?=__('m2')?> - {{fp.floorplan_maxsize}}<?=__('m2')?><br/>
                                                    <a class="small-btn blueText" href="" ng-click="
                                                        $parent.curr_t = 'proposals'; 
                                                        $parent.addProposal = 1;
                                                        rec.proposal.proposal_configs.floorplan_id = fp.id; 
                                                        rec.proposal.proposal_desc = rec.project.project_desc; 
                                                    "><i class="fa fa-plus"></i> <?=__('create_offer')?></a>
                                                </td>
                                                <td>

                                                    {{DtSetter('currencies_icons', rec.project.project_currency)}}{{nFormat( fp.floorplan_minprice )}}
                                                    <i class="grayText">({{DtSetter('currencies_icons', '<?=$currCurrency?>')}}{{currencyConverter( DtSetter('currencies', rec.project.project_currency), '<?=$this->Do->get('currencies')[$currCurrency]?>', fp.floorplan_minprice )}})</i> - 

                                                    {{DtSetter('currencies_icons', rec.project.project_currency)}}{{nFormat( fp.floorplan_maxprice )}}
                                                    <i class="grayText">({{DtSetter('currencies_icons', '<?=$currCurrency?>')}}{{currencyConverter( DtSetter('currencies', rec.project.project_currency), '<?=$this->Do->get('currencies')[$currCurrency]?>', fp.floorplan_maxprice )}})</i>
                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>                              
                                </div>
                                
                                <?php // Properties  ?>
                                <div ng-show="curr_t == 'properties'" class="grid">
                                    <div class=" row">
                                        <a ng-repeat="property in rec.project.properties"
                                            href="<?=$app_folder?>/admin/properties?view_rec={{property.id}}" class="img_thumb2 text-center" >
                                            <div class="img">
                                                <img ng-src="{{getPhoto(false, property.property_photos[0], 'properties')}}" show-img/>
                                            </div>
                                            <div><b>{{DtSetter('currencies_icons', property.property_currency)}}{{nFormat(property.property_price)}}</b></div>
                                            <div class="flex_center">{{property.property_title}}</div>
                                        </a>
                                    </div>                              
                                </div>
                                
                                <?php if ($is_offer) { ?>
                                    <div ng-show="curr_t == 'proposals'" class="grid">

                                    <?php // Proposals ?>
                                    <?php echo $this->element('Includes/proposals')?>

                                    </div>
                                <?php }?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>