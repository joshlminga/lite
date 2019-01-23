<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Mail Set-up | Configure emails </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_mail, '', ' autocomplete="off" '); ?>
					<div class="row">


						<?php foreach ($resultList as $row): ?>
							<?php if ($row->setting_title == 'mail_protocol'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="mail_protocol" value="mail"
			                                <?= ($row->setting_value == 'mail')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('mail') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="mail_protocol" value="sendmail" 
			                                <?= ($row->setting_value == 'sendmail')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('sendmail') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="mail_protocol" value="smtp" 
			                                <?= ($row->setting_value == 'smtp')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('smtp') ?>
			                            </label>
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
	                        <?php elseif ($row->setting_title == 'wordwrap'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="wordwrap" value="TRUE" 
			                                <?= ($row->setting_value == 'TRUE')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('TRUE') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="wordwrap" value="FALSE" 
			                                <?= ($row->setting_value == 'FALSE')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('FALSE') ?>
			                            </label>
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
	                        <?php elseif ($row->setting_title == 'mailtype'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="mailtype" value="text" 
			                                <?= ($row->setting_value == 'text')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('text') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="mailtype" value="html" 
			                                <?= ($row->setting_value == 'html')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('html') ?>
			                            </label>
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
	                        <?php else: ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?></label>
						                <input type="text" class="form-control" name="<?= $row->setting_title;?>" id="" autocomplete="off" 
						                value="<?= $row->setting_value; ?>">
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
							<?php endif ?>
						<?php endforeach ?>
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
