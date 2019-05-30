<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_save, ' autocomplete="off" '); ?>
					<input type="hidden" name="id" value="<?= $fieldList[0]->id;?>">
					<?php $required = json_decode($fieldList[0]->required, True); $totalRequired = count($required); ?>
					<?php $optional = json_decode($fieldList[0]->optional, True); $totalOptional = count($optional); ?>
					<?php $filters = json_decode($fieldList[0]->filters, True); ?>

					<div class="row">						
					<?php foreach ($required as $key => $value): ?>
						<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>
							<?php $show = array('user_name','user_email'); ?>
							<?php if (in_array($field_name, $show)): ?>
					            <?php if ($field_name == 'user_name'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
										    <input type="text" class="form-control" name="<?= $field_name; ?>" id="" 
										    	autocomplete="off" value="<?= set_value($field_name); ?>">
					            		</div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							    <?php else: ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
										    <input type="text" class="form-control" name="<?= $field_name; ?>" id="" 
										    	autocomplete="off" value="<?= set_value($field_name); ?>">
					            		</div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
					            <?php endif ?>
				            <?php endif ?>
						<?php endif ?>
					<?php endforeach ?>
					
					<?php if (!empty($optional)): ?>
					<?php foreach ($optional as $key => $value): ?>
						<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>
							<?php $show = array('user_gender'); ?>
							<?php if (in_array($field_name, $show)): ?>
					            <?php if ($field_name == 'user_gender'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
							            	<label><?= $value; ?> <small>(Select Gender)</small></label>
		                                    <select class="selectpicker form-control" name="<?= $field_name ?>">
		                                        <option value="male" selected>Male</option>
		                                        <option value="female">Female</option>
		                                    </select>
		                               	</div>
		                            </div>
		                       	</div>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
					<?php endforeach ?>
					<?php endif ?>
					</div>
					
					<div class="row">
					<?php if (!empty($optional)): ?>
					<?php foreach ($optional as $key => $value): ?>
						<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>
							<?php $show = array('user_mobile'); ?>
							<?php if (in_array($field_name, $show)): ?>
					            <?php if ($field_name == 'user_mobile'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> </label>
							                <input type="text" class="form-control" name="<?= $field_name; ?>" id="" autocomplete="off" 
							                value="<?= set_value($field_name); ?>">
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
								<?php endif ?>
							<?php endif ?>
						<?php endif ?>
					<?php endforeach ?>
					<?php endif ?>
					</div>

					<div class="row">
					    <div class="col-md-12 col-sm-12">
			                <div class="form-group">
			                    <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Save</button>
			                </div>
					    </div>
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
