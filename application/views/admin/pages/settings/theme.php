<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords('Theme Settings'); ?> <small>Main and Child</small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_theme, '', ' autocomplete="off" '); ?>
				<div class="row">
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Theme Name <i class="fa fa-asterisk"></i></label>
								<?php $theme_name = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'theme_name']); ?>
								<input type="text" class="form-control" name="theme_name" autocomplete="off" value="<?= $theme_name; ?>">
							</div>
							<span class="error"><?= form_error("theme_name") ?></span>
						</div>
					</div>

					<div class="col-md-5 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Theme Dir <i class="fa fa-asterisk"></i></label>
								<?php $theme_dir = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'theme_dir']); ?>
								<input type="text" class="form-control" name="theme_dir" autocomplete="off" value="<?= $theme_dir; ?>">
							</div>
							<span class="error"><?= form_error("theme_dir") ?></span>
						</div>
					</div>

					<div class="col-md-5 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Theme Assets <i class="fa fa-asterisk"></i></label>
								<?php $theme_assets = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'theme_assets']); ?>
								<input type="text" class="form-control" name="theme_assets" autocomplete="off" value="<?= $theme_assets; ?>">
							</div>
							<span class="error"><?= form_error("theme_assets") ?></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Child Theme Name </label>
								<?php $child_theme = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'child_theme']); ?>
								<input type="text" class="form-control" name="child_theme" autocomplete="off" value="<?= $child_theme; ?>">
							</div>
							<span class="error"><?= form_error("child_theme") ?></span>
						</div>
					</div>

					<div class="col-md-5 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Child Theme Dir </label>
								<?php $child_theme_dir = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'child_theme_dir']); ?>
								<input type="text" class="form-control" name="child_theme_dir" autocomplete="off" value="<?= $child_theme_dir; ?>">
							</div>
							<span class="error"><?= form_error("child_theme_dir") ?></span>
						</div>
					</div>

					<div class="col-md-5 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Child Theme Assets </label>
								<?php $child_theme_assets = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'child_theme_assets']); ?>
								<input type="text" class="form-control" name="child_theme_assets" autocomplete="off" value="<?= $child_theme_assets; ?>">
							</div>
							<span class="error"><?= form_error("child_theme_assets") ?></span>
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
