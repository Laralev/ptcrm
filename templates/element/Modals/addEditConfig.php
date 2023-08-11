<div class="modal fade" id="addEditConfig_mdl" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="listing-modal-1 modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
          <?=__('edit_config')?>
        </h4>
      </div>
      <div class="modal-body">

        <button type="button" id="config_btn" class="hideIt" ng-click="
            doGet('/admin/configs/index?list=1', 'list', 'configs');
            rec.config.id>0 ? '' : rec.config = {};
            doClick('.close');
          "></button>

        <form class="row" id="config_form" ng-submit="
            rec.config.img = filesInfo.config_photos;
            doSave(rec.config, 'config', 'configs', '#config_btn', '#config_preloader');">
            
            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label><?=__('config_key')?></label>
                <div class="div">
                    <?=$this->Form->control('config_key', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'text',
                        'disabled'=>true,
                        'ng-model'=>'rec.config.config_key',
                        'placeholder'=>__('config_key'),
                    ])?>
                    <span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-md-6 col-sm-6  form-group has-feedback">
                <label><?=__('config_value')?></label>
                <div class="div">
                    <?=$this->Form->control('config_value', [
                        'class'=>'form-control has-feedback-left',
                        'label'=>false,
                        'type'=>'text',
                        'ng-model'=>'rec.config.config_value',
                        'placeholder'=>__('config_value'),
                    ])?>
                    <span class="fa fa-cogs form-control-feedback left" aria-hidden="true"></span>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-info" id="config_preloader"><span></span> <i class="fa fa-save"></i> <?=__('save')?></button>
            </div>

        </form>

      </div>
    </div>
  </div>
</div>