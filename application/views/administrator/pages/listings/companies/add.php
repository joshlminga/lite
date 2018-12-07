<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Creat / Add new <?= strtolower($ModuleName); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_save, ' autocomplete="off" '); ?>
					<div class="row">
						<?php $kenya_cities = json_decode($cities[0]->fieldcustom_child, True); ?>
						<?php $category = json_decode(json_encode($categories), True); ?>
						<?php $employee_range = json_decode(json_encode($employee_range), True); ?>
						<?php $employee_range =json_decode( $employee_range[0]['fieldcustom_child'], True); ?>
						
						<input type="hidden" name="id" value="<?= $fieldList[0]->id;?>">
						<?php $required = json_decode($fieldList[0]->required, True); $totalRequired = count($required); ?>
						<?php $optional = json_decode($fieldList[0]->optional, True); $totalOptional = count($optional); ?>
						<?php $filters = json_decode($fieldList[0]->filters, True); ?>

						<?php if ($fieldList[0]->default == 'no'): ?>
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Set Default Filters <small>(Fields used when filtering)</small></label>
                                    <select class="selectpicker" name="listinglist_filters[]" multiple>
                                    	<?php foreach ($required as $key => $value): ?>
                                        <option 
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
								<?php if ($field_name == 'customer_name'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
		                                    <select class="selectpicker" name="<?= $field_name; ?>">
		                                    	<?php foreach ($username as $row): ?>
		                                        <option value="<?= $row->user_id ?>"><?= $row->user_name ?></option>
		                                    	<?php endforeach ?>
		                                    </select>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							    <?php elseif($field_name == 'employees'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
		                                    <select class="selectpicker" name="<?= $field_name; ?>">
						                    	<?php foreach ($employee_range['range'] as $d_key => $d_value): ?>
						                        <option value="<?= trim($d_key) ?>"><?= $d_value ?></option>
						                    	<?php endforeach ?>
		                                    </select>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							    <?php elseif($field_name == 'categories'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
		                                    <select class="selectpicker" name="<?= $field_name; ?>" id="categories">
		                                    	<option>select <?= $this->plural->singularize($value); ?>......... </option>
												<?php for($i =0; $i < count($category); $i++): ?>
		                                        <option value="<?= trim($category[$i]['fieldcustom_parent']); ?>"><?= ucwords($category[$i]['fieldcustom_parent']) ?></option>
												<?php endfor ?>
		                                    </select>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							</div>
							<div class="row">
                                <?php elseif($field_name == 'city'): ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
		                                    <select class="selectpicker" name="<?= $field_name; ?>" >
		                                    	<option>select <?= $this->plural->singularize($value); ?>......... </option>
		                                    	<?php foreach ($kenya_cities['city'] as $d_key => $d_value): ?>
		                                        <option value="<?= trim($d_key) ?>"><?= $d_value ?></option>
		                                    	<?php endforeach ?>
		                                    </select>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							</div>
							<div class="row">
                                <?php elseif($field_name == 'sub_categories'): ?>
							    <div class="col-md-12 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
						            		<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
		                                    <div id="sub_category">
		                                    </div>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
                                <?php elseif($field_name == 'description'): ?>
							    <div class="col-md-12 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> <i class="fa fa-asterisk"></i></label>
			                        		<textarea class="form-control auto-size" name="<?= strtolower($value) ?>" id="" 
			                        			autocomplete="off"><?= set_value($field_name); ?></textarea>
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
						<?php endforeach ?>

						<?php foreach ($optional as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>

							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
								<?php if ($field_name == 'location'): ?>
					            			<label><?= $value; ?> </label>
		                                    <select class="selectpicker" name="<?= $field_name; ?>">
		                                    	<option>select <?= $this->plural->singularize($value); ?>......... </option>
		                                    	<?php foreach ($kenya_cities['city'] as $d_key => $d_value): ?>
		                                        <option value="<?= trim($d_key) ?>"><?= $d_value ?></option>
		                                    	<?php endforeach ?>
		                                    </select>
								<?php elseif ($field_name == 'keywords'): ?>
					            			<label><?= $value; ?> <small>(Separate Value with comma)</small></label>
							                <input type="text" class="form-control" 
							                name="<?= $field_name; ?>" id="" autocomplete="off" 
							                value="<?= set_value($field_name); ?>">
								<?php else: ?>
					            			<label><?= $value; ?> </label>
							                <input type="text" class="form-control" 
							                name="<?= $field_name; ?>" id="" autocomplete="off" 
							                value="<?= set_value($field_name); ?>">
								<?php endif ?>
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
			                    <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Save</button>
			                </div>
					    </div>
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
