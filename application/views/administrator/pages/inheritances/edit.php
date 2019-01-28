<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($Module); ?> <small>Edit / Update <?= strtolower($Module); ?></small></h2>
            </div>
			

            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
					<div class="row">
						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
					    <div class="col-md-4 col-sm-12">
					        <div class="fg-line">
					            <label>Inheritance Type <small>(Select One)</small> <i class="fa fa-asterisk"></i></label>
	                            <select name="inheritance_type" class="chosen" data-placeholder="Choose Type...">
	                            	<?php for ($i = 0; $i < count($inheritance); $i++): ?>
	                            		<?php if (strtolower($inheritance[$i]->inheritance_type) == $resultList[0]->type): ?>
			                                <option value="<?= strtolower($inheritance[$i]->inheritance_type) ?>" selected="">
			                                	<?= ucwords($inheritance[$i]->inheritance_type) ?>
			                                </option>
	                            		<?php else: ?>
			                                <option value="<?= strtolower($inheritance[$i]->inheritance_type) ?>">
			                                	<?= ucwords($inheritance[$i]->inheritance_type) ?>
			                                </option>
	                            		<?php endif ?>
	                            	<?php endfor ?>
	                            </select>
                        	</div>
					        <span class="error"><?= form_error('inheritance_type') ?></span>
                        </div>
					    <div class="col-md-4 col-sm-12">
				            <div class="fg-line">
				            	<label>Inheritance Parent <small>(Parent Name)</small> <i class="fa fa-asterisk"></i></label>
	                            <select name="inheritance_parent" class="chosen" data-placeholder="Choose Parent...">
	                            	<?php for ($i = 0; $i < count($inheritance); $i++): ?>
	                            		<?php if (strtolower($inheritance[$i]->inheritance_id) == $resultList[0]->parent): ?>
			                                <option value="<?= strtolower($inheritance[$i]->inheritance_id) ?>" selected="">
			                                	<?= ucwords($inheritance[$i]->inheritance_title) ?>
			                                </option>
	                            		<?php else: ?>
			                                <option value="<?= strtolower($inheritance[$i]->inheritance_id) ?>">
			                                	<?= ucwords($inheritance[$i]->inheritance_title) ?>
			                                </option>
	                            		<?php endif ?>
	                            	<?php endfor ?>
	                            </select>
				            </div>
				            <span class="error"><?= form_error('inheritance_parent') ?></span>
					    </div>
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Title <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="inheritance_title" id="" autocomplete="off" value="<?= $resultList[0]->title; ?>">
					            </div>
					            <span class="error"><?= form_error('inheritance_title') ?></span>
					        </div>
					    </div>

					    <div class="col-md-12 col-sm-12">
			                <div class="form-group">
			                    <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Update</button>
			                </div>
					    </div>
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
