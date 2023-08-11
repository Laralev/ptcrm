

<?php 
    $ctrl = $this->request->getParam('controller') == 'Properties' ? 'property' : 'project';
    $prefix = $this->request->getParam('controller') == 'Properties' ? 'PROP' : 'PROJ';
?>

<div class="modal fade" id="searchLogs_mdl" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="listing-modal-1 modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title">
					<?=__('search_and_filter')?>
				</h2>
			</div>
			<div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" novalidate="novalidate" id="searchlogs_form" class="row" ng-submit="doSearch()" >

                                <?php // GENERAL SEARCH ?>
                                <div class="col-sm-12">
                                    <h5 data-toggle="collapse" data-target="#searchlogs_sec" class="sec_header"> <?=__('general_search')?> </h5>
                                </div>
                                <div id="searchlogs_sec" class="collapse show col-12" data-parent="#searchlogs_form">
                                    <div class="row">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>