<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Inheritance Type | Setup </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_inheritance, '', ' autocomplete="off" '); ?>
					<div class="row">
						<?php foreach ($resultList as $row): ?>
							<?php if ($row->setting_title == 'inheritance_data'): ?>
						    <div class="col-md-12 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?> Type</label>
						                <input type="text" class="form-control" name="<?= $row->setting_title;?>" id="" autocomplete="off" 
						                value="<?= $row->setting_value; ?>">
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
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
