<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify) && $notify != 'blank')? $notify : ''; ?>
				<?= form_open($form_edit, ' autocomplete="off" enctype="multipart/form-data" '); ?>
					<div class="row">

						<?php 
							for($i = 0; $i < count($companies); $i++){
								$selected = $companies[$i];
								$companiesArray = json_decode(json_encode($selected), True);
								foreach ($selected as $key => $value) {
									if ($key == 'listinglist_id') {										
										$company_data = json_decode(next($selected), true);
										$company_name = $company_data['company_name'];
										$company[$value] = $company_name;
									}
								}
							}
						?>


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
								<?php if ($field_name == 'company'): ?>
			                    <select class="selectpicker" name="<?= $field_name ?>">
			                    	<?php foreach ($company as $d_key => $d_value): ?>
			                    		<?php if ($d_key == $data[$field_name]): ?>
                                     	<option value="<?= trim(stripcslashes($d_key)) ?>" selected="">
                                     		<?= trim(stripcslashes($d_value))?>                                     		
                                     	</option>
			                    		<?php else: ?>
                                     	<option value="<?= trim(stripcslashes($d_key)) ?>">
                                     		<?= trim(stripcslashes($d_value))?>                                     		
                                     	</option>
			                    		<?php endif ?>
			                    	<?php endforeach ?>
			                    </select>
								<?php else: ?>
									<input type="text" class="form-control" name="<?= $field_name; ?>" id=""autocomplete="off" 
									value="<?= stripcslashes($data[$field_name]); ?>">
								<?php endif ?>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							<?php endif ?>
						<?php endforeach ?>




						<?php foreach ($optional as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							<?php $field_name = strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>

                                <?php if($field_name == 'description'): ?>
							    <div class="col-md-12 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> </label>
			                        		<textarea class="form-control auto-size" name="<?= strtolower($field_name) ?>" id="" 
			                        			autocomplete="off"><?= stripcslashes($data[$field_name]); ?></textarea>
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
							    <?php elseif ($field_name == 'photos'): ?>
							    <?php $up = 1; ?>
							    <?php while ( $up <= 5):?>
								    <div class="col-md-4 col-sm-12" id="">
								        <div class="form-group">
								            <div class="fg-line">
						            			<label><p> <?= ucwords($field_name)." ".$up?> </p></label>
			                                    <div class="fileinput fileinput-new" data-provides="fileinput">
			                                        <span class="btn btn-primary btn-file m-r-10">
			                                            <span class="fileinput-new">Select file</span>
			                                            <span class="fileinput-exists">Change</span>
			                                            <input type="file" name="<?= $field_name ?>[]">
			                                        </span>
			                                        <span class="fileinput-filename"></span>
			                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
			                                    </div>
			                            	</div>
							            	<span class="error"><?= form_error($field_name) ?></span>
								        </div>
								    </div>
								<?php $up++; ?>
								<?php endwhile ?>
								<?php else: ?>
							    <div class="col-md-4 col-sm-12" id="">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label><?= $value; ?> </label>
							                <input type="text" class="form-control" 
							                name="<?= $field_name; ?>" id="" autocomplete="off" 
							                value="<?= stripcslashes($data[$field_name]); ?>">
							            </div>
							            <span class="error"><?= form_error($field_name) ?></span>
							        </div>
							    </div>
								<?php endif ?>
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
