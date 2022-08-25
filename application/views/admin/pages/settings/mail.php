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
					    <div class="col-md-4 col-sm-12">
	            			<?php $mail_protocol = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'mail_protocol']); ?>
					        <div class="form-group">
					            <div class="">
					            	<p><strong>Mail Protocol</strong></p>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="mail_protocol" value="mail" <?= ($mail_protocol == 'mail') ? 'checked' : ''; ?>>
		                                <i class="input-helper"></i> <?= ucwords('mail') ?>
		                            </label>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="mail_protocol" value="sendmail" <?= ($mail_protocol == 'sendmail') ? 'checked' : ''; ?>>
		                                <i class="input-helper"></i> <?= ucwords('sendmail') ?>
		                            </label>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="mail_protocol" value="smtp" <?= ($mail_protocol == 'smtp') ? 'checked' : ''; ?>>
		                                <i class="input-helper"></i> <?= ucwords('smtp') ?>
		                            </label>
					            </div>
		                        <span class="error"><?= form_error("mail_protocol") ?></span>
					        </div>
					    </div>

					    <div class="col-md-3 col-sm-12">
	            			<?php $smtp_host = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'smtp_host']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Smtp Host </label>
					                <input type="text" class="form-control" name="smtp_host" autocomplete="off" value="<?= $smtp_host; ?>">
					            </div>
		                        <span class="error"><?= form_error("smtp_host") ?></span>
					        </div>
					    </div>

					    <div class="col-md-3 col-sm-12">
	            			<?php $smtp_user = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'smtp_user']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Smtp User </label>
					                <input type="text" class="form-control" name="smtp_user" autocomplete="off" value="<?= $smtp_user; ?>">
					            </div>
		                        <span class="error"><?= form_error("smtp_user") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
	            			<?php $smtp_pass = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'smtp_pass']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Smtp Pass </label>
					                <input type="text" class="form-control" name="smtp_pass" autocomplete="off" value="<?= $smtp_pass; ?>">
					            </div>
		                        <span class="error"><?= form_error("smtp_pass") ?></span>
					        </div>
					    </div>
	            	</div>

	            	<div class="row">

					    <div class="col-md-1 col-sm-12">
	            			<?php $smtp_port = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'smtp_port']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Smtp Port </label>
					                <input type="text" class="form-control" name="smtp_port" autocomplete="off" value="<?= $smtp_port; ?>">
					            </div>
		                        <span class="error"><?= form_error("smtp_port") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
	            			<?php $smtp_timeout = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'smtp_timeout']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Smtp Timeout </label>
					                <input type="text" class="form-control" name="smtp_timeout" autocomplete="off" value="<?= $smtp_timeout; ?>">
					            </div>
		                        <span class="error"><?= form_error("smtp_timeout") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
	            			<?php $smtp_crypto = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'smtp_crypto']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Smtp Crypto </label>
					                <input type="text" class="form-control" name="smtp_timeout" autocomplete="off" value="<?= $smtp_crypto; ?>">
					            </div>
		                        <span class="error"><?= form_error("smtp_crypto") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="">
	            					<?php $wordwrap = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'wordwrap']); ?>
					            	<p><strong>Wordwrap</strong></p>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="wordwrap" value="TRUE" <?= ($wordwrap == 'TRUE')? 'checked' : ''; ?>>
		                                <i class="input-helper"></i>
		                                <?= ucwords('TRUE') ?>
		                            </label>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="wordwrap" value="FALSE" <?= ($wordwrap == 'FALSE')? 'checked' : ''; ?>>
		                                <i class="input-helper"></i>
		                                <?= ucwords('FALSE') ?>
		                            </label>
					            </div>
		                        <span class="error"><?= form_error("wordwrap") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
	            			<?php $wrapchars = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'wrapchars']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Wrapchars </label>
					                <input type="text" class="form-control" name="wrapchars" autocomplete="off" value="<?= $wrapchars; ?>">
					            </div>
		                        <span class="error"><?= form_error("wrapchars") ?></span>
					        </div>
					    </div>

					    <div class="col-md-3 col-sm-12">
					        <div class="form-group">
					            <div class="">
	            					<?php $mailtype = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'mailtype']); ?>
					            	<p><strong>Mailtype </strong></p>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="mailtype" value="text" <?= ($mailtype== 'text')? 'checked' : ''; ?>>
		                                <i class="input-helper"></i> <?= ucwords('text') ?>
		                            </label>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="mailtype" value="html" <?= ($mailtype == 'html')? 'checked' : ''; ?>>
		                                <i class="input-helper"></i> <?= ucwords('html') ?>
		                            </label>
					            </div>
		                        <span class="error"><?= form_error("mailtype") ?></span>
					        </div>
					    </div>
	            	</div>

	            	<div class="row">
					    <div class="col-md-2 col-sm-12">
	            			<?php $charset = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'charset']); ?>
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Charset </label>
					                <input type="text" class="form-control" name="charset" autocomplete="off" value="<?= $charset; ?>">
					            </div>
		                        <span class="error"><?= form_error("charset") ?></span>
					        </div>
					    </div>
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
