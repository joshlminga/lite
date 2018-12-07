<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($Module); ?> <small>Edit / Update <?= strtolower($Module); ?></small></h2>
                <p style="font-size: 11px">
                	Separate items using comma e.g 1,2,3 if it's the last child
                </p>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_edit, ' autocomplete="off" '); ?>
					<div class="row">
						<input type="hidden" name="id" value="<?= $dataList[0]->id;?>">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Field Type <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" id="" value="<?= stripcslashes($resultList[0]->field_type); ?>" disabled="">
					            </div>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Field Group <small>(unique group name identifier) 200 max</small> <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" id="" value="<?= stripcslashes($dataList[0]->group_list); ?>" disabled="">
					            </div>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label><?= $resultList[0]->parent_field; ?><i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="fieldcustom_parent" id="" autocomplete="off" 
					                value="<?= stripcslashes($dataList[0]->parent_list); ?>">
					            </div>
					            <span class="error"><?= form_error('fieldcustom_parent') ?></span>
					        </div>
					    </div>

						<?php $children = json_decode($resultList[0]->children, True); $totalChild = count($children); ?>
						<?php $children_list = json_decode($dataList[0]->children_list, True); ?>
						<?php foreach ($children as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							    <div class="col-md-4 col-sm-12 duplicated" id="duplicater">
							        <div class="form-group">
							            <div class="fg-line">
							            	<label><?= $value; ?>							            		
							            		<?php if ($totalChild == 1): ?><small>(separate item by comma)</small><?php endif ?>
							            	</label>
							            	<?php if ($totalChild == 1): ?>
                                    		<textarea class="form-control auto-size" name="<?= strtolower($value) ?>" id="" autocomplete="off"><?= stripcslashes(implode(',',$children_list[strtolower(str_replace(" ", "_",trim($value)))])); ?></textarea>
                                    		<?php else: ?>
						                		<input type="text" class="form-control" name="<?= strtolower($value) ?>" id="" autocomplete="off" 
						                		value="<?= stripcslashes(implode(',',$children_list[strtolower(str_replace(" ", "_",trim($value)))])); ?>">
                                    		<?php endif ?>
							            </div>
							            <span class="error"><?= form_error($key) ?></span>
							        </div>
							    </div>
							<?php endif ?>
						<?php $totalChild --; endforeach ?>
					</div>

					<div class="row">
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
