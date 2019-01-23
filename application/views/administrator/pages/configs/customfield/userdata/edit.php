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
						
						<?php if ($fieldList[0]->default == 'no'): ?>
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Set Default Filters <small>(Fields used when filtering)</small></label>
									<?php $filters = json_decode($resultList[0]->filters, True); ?>
									<?php $filter_data = array_values($filters) ?>
                                    <select class="selectpicker" name="listinglist_filters[]" multiple>
                                    	<?php foreach ($required as $key => $value): ?>
                                    	<?php if (in_array(strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))), $filter_data)):?>
                                    		<?php $filter_selected = 'selected=""'; ?>
                                    	<?php else: ?>
                                    		<?php $filter_selected = ''; ?>
                                    	<?php endif ?>
                                        <option <?= $filter_selected; ?> 
                                        value="<?= strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>"><?= $value ?>
                                        </option>
                                    	<?php endforeach ?>
                                    </select>
					            </div>
					            <span class="error"><?= form_error('listinglist_filters') ?></span>
					        </div>
					    </div>
						<?php endif ?>


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


						<?php foreach ($optional as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>

							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> </label>
							                <input type="text" class="form-control" 
							                name="<?= $field_name; ?>" id="" autocomplete="off" 
							                <?php if (array_key_exists($field_name, $data)): ?>
							                	value="<?= stripcslashes($data[$field_name]); ?>"
							                <?php else: ?>
							                	value=""
							                <?php endif ?>>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							<?php endif ?>
						<?php endforeach ?>
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
