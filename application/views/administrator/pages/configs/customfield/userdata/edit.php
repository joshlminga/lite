<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify) && $notify != 'blank')? $notify : ''; ?>
				<?= form_open($form_edit, ' autocomplete="off" '); ?>
					<div class="row">

						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">						
						<?php $required = json_decode($fieldList[0]->required, True); $totalRequired = count($required); ?>
						<?php $optional = json_decode($fieldList[0]->optional, True); $totalOptional = count($optional); ?>
						<?php $data = json_decode($resultList[0]->data, True);?>
						
						<?php if (!empty($required)): ?>
						<?php foreach ($required as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
								    <input type="text" class="form-control" name="<?= $field_name; ?>" id="" 
								    	autocomplete="off" value="<?= stripcslashes($data[$field_name]); ?>">
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							<?php endif ?>
						<?php endforeach ?>
						<?php endif ?>

						<?php if (!empty($optional)): ?>
						<?php foreach ($optional as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>

							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
										<?php if ($field_name == 'user_gender'): ?>
							            	<label><?= $value; ?> <small>(Select Gender)</small></label>
		                                    <select class="selectpicker" name="<?= $field_name ?>">
		                                    	<?php if (array_key_exists($field_name, $data)): ?>
			                                    	<option value="male" 
			                                    		<?= (strtolower(stripcslashes($data[$field_name])) == 'male')?'selected':''; ?>>
			                                    		Male
			                                    	</option>
			                                    	<option value="female" 
			                                    		<?= (strtolower(stripcslashes($data[$field_name])) == 'female')?'selected':''; ?>>
			                                    		Female
			                                    	</option>
		                                    	<?php else: ?>
			                                        <option value="male" selected>Male</option>
			                                        <option value="female">Female</option>
		                                    	<?php endif ?>
		                                    </select>
										<?php else: ?>
					            			<label><?= $value; ?> </label>
							                <input type="text" class="form-control" 
							                name="<?= $field_name; ?>" id="" autocomplete="off" 
							                <?php if (array_key_exists($field_name, $data)): ?>
							                	value="<?= stripcslashes($data[$field_name]); ?>"
							                <?php else: ?>
							                	value=""
							                <?php endif ?>>
										<?php endif ?>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							<?php endif ?>
						<?php endforeach ?>
						<?php endif ?>
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
