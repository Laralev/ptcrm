<?php
    $parent_id = isset($this->request->getParam('pass')[0]) ? $this->request->getParam('pass')[0] : 0;
?>

<div class="modal fade" id="addEditCategory_mdl" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="listing-modal-1 modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					<h4 ng-if="!rec.category.id"><?= __('add') ?></h4>
					<h4 ng-if="rec.category.id"><?= __('edit') ?></h4>
				</h4>
			</div>

			<div class="modal-body">
				<div class="x_content">

					<button ng-click="
							doGet('/admin/categories/index?list=1', 'list', 'categories');
							newEntity('category');
						" id="category_btn" class="hideIt"></button>

					<form class="form-label-left input_mask " id="category_form" enctype="multipart/form-data" novalidate="novalidate" 
						ng-submit="doSave 
						(rec.category, 'category', 'categories', '#category_btn'); ">

						<div class="col-md-12 col-sm-12  form-group has-feedback" ng-if="rec.category.parent_name">
							<h2><?= __('parent_id') ?> : {{rec.category.parent_name}}</h2>
						</div>

						<div class="col-md-12 col-sm-12  form-group has-feedback">
							<label><?= __('category_name') ?></label>
							<div class="div">
								<?= $this->Form->text('category_name', [
									'type' => 'text',
									'class' => 'form-control has-feedback-left',
									'ng-model' => 'rec.category.category_name'
								]) ?>
								<span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>

						<div class="col-md-6 col-6  form-group has-feedback">
							<label><?= __('language_id') ?></label>
							<div class="div">
								<?= $this->Form->text('language_id', [
									'type' => 'select',
									'options'=>$this->Do->lcl( $this->Do->get('langs') ),
									'class' => 'form-control has-feedback-left',
									'ng-model' => 'rec.category.language_id'
								]) ?>
								<span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="col-md-6 col-6  form-group has-feedback">
							<label><?= __('category_priority') ?></label>
							<div class="div">
								<?= $this->Form->text('category_priority', [
									'type' => 'text',
									'class' => 'form-control has-feedback-left',
									'ng-model' => 'rec.category.category_priority'
								]) ?>
								<span class="fa fa-header form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>

						<div class="col-md-12 col-sm-12  form-group has-feedback">
							<label><?= __('category_configs.icon') ?></label>
							<div class="div">
								<?= $this->Form->text('category_configs.icon', [
									'type' => 'text',
									'class' => 'form-control has-feedback-left',
									'ng-model' => 'rec.category.category_configs.icon',
									'fa-icons'=>'',
								]) ?>
								<span class="fa {{rec.category.category_configs.icon||'fa-tag'}} form-control-feedback left" aria-hidden="true"></span>
							</div>
							<div class="icons_div"></div>
						</div>

						<div class="clearfix"></div>

						<div class="form-group ">
							<div class="col-md-12 col-sm-6  form-group has-feedback ">
								<button type="submit" class="btn btn-info"><span><i class="fa fa-save"></i></span> <?= __('save') ?></button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>