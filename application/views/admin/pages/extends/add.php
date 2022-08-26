<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Edit / Update </small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_save, '', ' autocomplete="off" '); ?>
				<div class="row">
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Setting Title <i class="fa fa-asterisk"></i></label>
								<div class="select">
									<select class="chosen" name="setting_title" autocomplete="off">
										<?php foreach ($settTitle as $key => $value) : ?>
											<option value="<?= strtolower($key); ?>" <?= set_select('setting_title', $key); ?>><?= ucwords($value); ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<span class="error"><?= form_error('setting_title') ?></span>
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Setting Flg <i class="fa fa-asterisk"></i></label>
								<div class="select">
									<select class="form-control" name="setting_flg" autocomplete="off">
										<option value="1" <?= set_select('setting_flg', 1); ?>><?= ucwords('Enabled'); ?></option>
										<option value="0" <?= set_select('setting_flg', 0, True); ?>><?= ucwords('Disabled'); ?></option>
									</select>
								</div>
							</div>
							<span class="error"><?= form_error('setting_flg') ?></span>
						</div>
					</div>
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Name <i class="fa fa-asterisk"></i></label>
								<input type="text" class="form-control" name="name" autocomplete="off" value="<?= set_value('name'); ?>">
							</div>
							<span class="error"><?= form_error('name') ?></span>
						</div>
					</div>

					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Menu Path </label>
								<input type="text" class="form-control" name="menu_path" id="" autocomplete="off" value="<?= set_value('menu_path'); ?>">
							</div>
							<span class="error"><?= form_error('menu_path') ?></span>
						</div>
					</div>

					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Setting Default <small>(Max 25)</small></label>
								<input type="text" class="form-control" name="setting_default" value="<?= set_value('setting_default'); ?>">
							</div>
							<span class="error"><?= form_error('setting_default') ?></span>
						</div>
					</div>
				</div>

				<div class="auto_box_area">
					<div class="row auto_box" num="1">
						<div class="col-md-4 col-sm-12 col-xs-12 auto-key">
							<div class="form-group">
								<div class="fg-line">
									<label>Route Name</label>
									<input type="text" name="route[]" class="form-control" value="" placeholder="example/(:any)">
								</div>
							</div>
						</div>

						<div class="col-md-7 col-sm-12 col-xs-12 auto-value">
							<div class="form-group">
								<div class="fg-line">
									<label>Controller</label>
									<input type="text" name="controller[]" class="form-control" value="" placeholder="Folder/ControllerName/Method/$1">
								</div>
							</div>
						</div>

						<div class="col-md-1 col-sm-12 col-xs-12 auto-action">
							<div class="form-group">
								<div class="fg-line">
									<a onclick="removeRoute(this.getAttribute('action'))" action="1" class="btn btn-sm btn-danger">
										<i class="fa fa-trash"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<button type="button" onclick="addRoute()" class="btn btn-success btn-xs waves-effect">
								Add Route +
							</button>

							<button type="button" onclick="removeRoute()" class="btn btn-danger btn-xs waves-effect">
								Remove Route -
							</button>
						</div>
					</div>
				</div>

				<hr />

				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Additional Json</label>
								<textarea class="form-control auto-size" name="additionaljson" autocomplete="off" placeholder='{"key":"value"}'></textarea>
							</div>
						</div>
						<span class="error"><?= form_error("additionaljson") ?></span>
					</div>
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
