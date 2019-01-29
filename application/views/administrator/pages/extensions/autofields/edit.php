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
					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" id="" autocomplete="off" disabled="" 
                                    value="<?= ucwords(str_replace("_", " ",stripcslashes($resultList[0]->title)));?>">
					            </div>
					        </div>
					    </div>
					</div>

					<?php $itemData = json_decode($resultList[0]->data, True); ?>

					<div class="row">
						<?php foreach ($itemData as $key => $value): ?>
							<?php if (!is_null($key) && !empty($key)): ?>
						    <div class="col-md-6 col-sm-12 labelItem" id="itemLabel">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label>Item Label </label>
						                <input type="text" class="form-control" name="autofield_label[]" id="" autocomplete="off" 
						                value="<?= stripcslashes(ucwords(str_replace("_", " ",$key))); ?>">
						            </div>
						            <span class="error"><?= form_error('autofield_label') ?></span>
						        </div>
						    </div>

						    <div class="col-md-6 col-sm-12 valueItem" id="itemValue">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label>Item Value </label>
						                <input type="text" class="form-control" name="autofield_value[]" id="" autocomplete="off" 
						                value="<?= stripcslashes($value); ?>">
						            </div>
						            <span class="error"><?= form_error('autofield_value') ?></span>
						        </div>
						    </div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
					<div class="row">
					    <div class="col-md-4 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="autoaddData()" class="btn btn-success btn-xs waves-effect">
			                		Add Fields +
			                	</button>

			                	<button type="button" onclick="autoremoveData()" class="btn btn-danger btn-xs waves-effect">
			                		Remove Fields -
			                	</button>
					        </div>
					    </div>
					    <div class="col-md-8 col-sm-12">
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
