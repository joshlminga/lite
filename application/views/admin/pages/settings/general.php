<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site customization</small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_general, '', ' autocomplete="off" '); ?>
					<div class="row">
					    <div class="col-md-7 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Site Title  <i class="fa fa-asterisk"></i></label>
					            	<?php $site_title = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'site_title']); ?>
					                <input type="text" class="form-control" name="site_title" autocomplete="off" value="<?= $site_title; ?>">
					            </div>
		                        <span class="error"><?= form_error("site_title") ?></span>
					        </div>
					    </div>

					    <div class="col-md-3 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Site Slogan  <i class="fa fa-asterisk"></i></label>
					            	<?php $site_slogan = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'site_slogan']); ?>
					                <input type="text" class="form-control" name="site_slogan" autocomplete="off" value="<?= $site_slogan; ?>">
					            </div>
		                        <span class="error"><?= form_error("site_slogan") ?></span>
					        </div>
					    </div>

					    <div class="col-md-2 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Site Status <i class="fa fa-asterisk"></i></label>
					            	<?php $site_status = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'site_status']); ?>
			                        <select class="selectpicker p-l-10" name="site_status">
			                            <option value="online" <?= ('online' == $site_status) ? 'selected' :''; ?>><?= ucwords('online') ?></option>
			                            <option value="offline" <?= ('offline' == $site_status) ? 'selected' :''; ?>><?= ucwords('offline') ?></option>
			                        </select>
					            </div>
		                        <span class="error"><?= form_error("site_status") ?></span>
					        </div>
					    </div>
				   	</div>

				   	<div class="row">
					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Offline Message  <i class="fa fa-asterisk"></i></label>
					            	<?php $offline_message = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'offline_message']); ?>
			                        <textarea class="form-control auto-size" name="offline_message" autocomplete="off"><?= $offline_message; ?></textarea>
					            </div>
		                        <span class="error"><?= form_error("offline_message") ?></span>
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
