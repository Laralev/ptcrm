<?php
$ctrl = $this->request->getParam('controller') == 'Properties' ? 'property' : 'project';
$prefix = $this->request->getParam('controller') == 'Properties' ? 'PROP' : 'PROJ';
?>

<div class="modal fade modal-right" id="search_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="listing-modal-1 modal-dialog modal-lg aside-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title">
                    <?= __('search_and_filter') ?>
                </h2>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" novalidate="novalidate" id="search_form" class="row" ng-submit=" rec.search.page = 1; doSearch(); ">

                                <!-- <?php // GENERAL SEARCH 
                                ?>
                                <div class="col-sm-12">
                                    <h5 data-toggle="collapse" data-target="#search_sec" class="sec_header"> <?= __('general_search') ?> </h5>
                                </div>
                                <div id="search_sec" class="collapse show col-12" data-parent="#search_form">
                                    <div class="row">

                                        <?php if ($ctrl == 'property') { ?>

                                            <div class="mb-3 col-12">
                                                <label><?= __('project_id') ?></label>
                                                <div class="div">
                                                    <select class="form-control selectpicker" ng-model="rec.search.project_id" data-live-search="true" multiple="true" multi-select="1" data-done-button="true" actn="doClick('#submit_btn')" data-size="6">
                                                        <option ng-value="key" ng-repeat="(key, itm) in lists.projects_list">{{itm}}</option>
                                                    </select>
                                                    <!-- <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span> -->
                                                </div>
                                            </div>

                                           
                                            </div>
                                        <?php } ?> -->
                                        
                                        <div class="mb-2 col-sm-8">
    <label><?= __('search_keyword') ?></label>
    <div class="div">
        <input class="form-control has-feedback-left"
               type="text"
               placeholder="<?= __('input_keyword') ?>"
               ng-model="rec.search2.keyword">
        <span class="fa fa-search form-control-feedback left"></span>
        <button ng-click="doClick()" class="onfly_btn"><i class="fa fa-search"></i></button>
    </div>
</div>
                  
                                    </div>
                                </div>
                                <div class="col-md-6 col-6 form-group has-feedback">
    <label><?= __('client_name') ?></label>
    <div class="div">
        <label class="radio-inline">
            <input type="radio" 
                ng-change="doSearch(rec.search)"
                ng-model="rec.search.expense_type" ng-value="1"> income
        </label>
        <label class="radio-inline">
            <input type="radio" 
                ng-change="doSearch(rec.search)"
                ng-model="rec.search.client_name" ng-value="2"> outgoing
        </label>
            </div>
                </div>
            </div>

            <div class="mb-2 col-sm-8">
                 <label><?= __('client_name') ?></label>
                 <div class="div">                                                                          
          <?= $this->Form->control('stat_created', [
                    'class' => 'form-control has-feedback-left', 'label' => false,
                    'type' => 'text', 'placeholder' => __('stat created'),
                    'ng-model' => 'rec.search.client_name',
                    ]) ?>
            <span class="fa fa-search form-control-feedback left"></span>
            <button ng-click="doClick" class="onfly_btn"><i class="fa fa-search"></i></button>
            </div>
                </div>

            <div class="mb-2 col-sm-8">
                 <label><?= __('expense_amount') ?></label>
                 <div class="div">                                                                          
          <?= $this->Form->control('expense_amount', [
                    'class' => 'form-control has-feedback-left', 'label' => false,
                    'type' => 'number', 'placeholder' => __('enter amount'),
                    'ng-model' => 'rec.search.expense_amount',
                    ]) ?>
            <span class="fa fa-search form-control-feedback left"></span>
            <button ng-click="doClick" class="onfly_btn"><i class="fa fa-search"></i></button>
            </div>
                </div>

                   <!-- <div class="col-md-6 col-6 form-group has-feedback">
    <label><?= __('expense_currency') ?></label>
    <div class="div">
        <label class="checkbox-inline">
            <input type="checkbox" ng-change="doSearch(rec.search)" ng-model="rec.search.expense_currency.TRY" > TRY
        </label>
        <label class="checkbox-inline">
            <input type="checkbox"  ng-change="doSearch(rec.search)" ng-model="rec.search.expense_currency.USD" > USD
        </label>
        <label class="checkbox-inline">
            <input type="checkbox"  ng-change="doSearch(rec.search)" ng-model="rec.search.expense_currency.EUR"> EUR
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" ng-change="doSearch(rec.search)" ng-model="rec.search.expense_currency.GBP" > GBP
        </label>
    </div>
</div>                   -->
<div class="col-md-6 col-6 form-group has-feedback"> 
                                    <label><?= __('stat_created') ?></label> 
                                            <div class="div">
                                                <?= $this->Form->control('stat_created', [
                                                    'class' => 'form-control has-feedback-left', 'label' => false,
                                                    'type' => 'text', 'placeholder' => __('stat_created'),
                                                    'ng-model' => 'rec.search.stat_created',
                                                ]) ?>
                                                <span class="fa fa-search form-control-feedback left"></span>
                                                <button ng-click="doClick('#submit_btn')" class="onfly_btn"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    
                                    <!-- <div class="col-sm-12 mb-5"></div> -->
                                    <div class="col-md-6 col-6 form-group has-feedback"> 
<label><?= __(' rec_state ') ?></label>
<div class="div">
    <label class="radio-inline">
        <input type="radio"
               ng-change="doSearch(rec.search)"
               ng-model="rec.search.rec_state" ng-value="1"> wait
    </label>
    <label class="radio-inline">
        <input type="radio"
               ng-change="doSearch(rec.search)"
               ng-model="rec.search.rec_state" ng-value="2"> paid
    </label>
    <label class="radio-inline">
        <input type="radio"
               ng-change="doSearch(rec.search)"
               ng-model="rec.search.rec_state" ng-value="3"> overdue
    </label>
</div>

                <label><?= __('services_id') ?></label>
                                            <div class="div">
                                                <?= $this->Form->control('services_id', [
                                                    'class' => 'form-control has-feedback-left', 'label' => false,
                                                    'type' => 'text', 'placeholder' => __('services_id'),
                                                    'ng-model' => 'rec.search.services_id',
                                                ]) ?>
                                                <span class="fa fa-search form-control-feedback left"></span>
                                                <button ng-click="doClick('#submit_btn')" class="onfly_btn"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 form-group has-feedback">
                        </div>
            </div>
        </div>
    </div>
</div>