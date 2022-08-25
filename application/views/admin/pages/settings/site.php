<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('Site Configs'); ?> <small>Core</small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_site, '', ' autocomplete="off" '); ?>
					<div class="row">
					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Site URL  <i class="fa fa-asterisk"></i></label>
					            	<?php $site_url = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'site_url']); ?>
					                <input type="text" class="form-control" name="site_url" autocomplete="off" value="<?= $site_url; ?>">
					            </div>
		                        <span class="error"><?= form_error("site_url") ?></span>
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>API URL  <i class="fa fa-asterisk"></i></label>
					            	<?php $api_url = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'api_url']); ?>
					                <input type="text" class="form-control" name="api_url" autocomplete="off" value="<?= $api_url; ?>">
					            </div>
		                        <span class="error"><?= form_error("api_url") ?></span>
					        </div>
					    </div>
				   	</div>

				   	<div class="row">
					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Session Key  <i class="fa fa-asterisk"></i></label>
					            	<?php $session_key = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'session_key']); ?>
					                <input type="text" class="form-control" name="session_key" autocomplete="off" value="<?= $session_key; ?>">
					            </div>
		                        <span class="error"><?= form_error("session_key") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Token Name <i class="fa fa-asterisk"></i></label>
					            	<?php $token_name = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'token_name']); ?>
					                <input type="text" class="form-control" name="token_name" autocomplete="off" value="<?= $token_name; ?>">
					            </div>
		                        <span class="error"><?= form_error("token_name") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Token Length <i class="fa fa-asterisk"></i></label>
					            	<?php $token_length = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'token_length']); ?>
					                <input type="text" class="form-control" name="token_length" autocomplete="off" value="<?= $token_length; ?>">
					            </div>
		                        <span class="error"><?= form_error("token_length") ?></span>
					        </div>
					    </div>
					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Token Use <i class="fa fa-asterisk"></i></label>
					            	<?php $token_use = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'token_use']); ?>
					                <input type="text" class="form-control" name="token_use" autocomplete="off" value="<?= $token_use; ?>">
					            </div>
		                        <span class="error"><?= form_error("token_use") ?></span>
					        </div>
					    </div>
					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Token Time <i class="fa fa-asterisk"></i></label>
					            	<?php $token_time = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'token_time']); ?>
					                <input type="text" class="form-control" name="token_time" autocomplete="off" value="<?= $token_time; ?>">
					            </div>
		                        <span class="error"><?= form_error("token_time") ?></span>
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
