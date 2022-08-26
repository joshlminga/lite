<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Edit / Update </small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
				<div class="row">
					<input type="hidden" name="id" value="<?= $resultList[0]->id; ?>">
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Setting Title <i class="fa fa-asterisk"></i></label>
								<div class="select">
									<select class="chosen" name="setting_title" autocomplete="off">
										<?php foreach ($settTitle as $key => $value) : ?>
											<option value="<?= strtolower($key); ?>" <?= ($resultList[0]->title == $key) ? 'selected' : ''; ?>><?= ucwords($value); ?></option>
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
										<option value="1" <?= ($resultList[0]->flg == 1) ? 'selected' : ''; ?>><?= ucwords('Enabled'); ?></option>
										<option value="0" <?= ($resultList[0]->flg == 0) ? 'selected' : ''; ?>><?= ucwords('Disabled'); ?></option>
									</select>
								</div>
							</div>
							<span class="error"><?= form_error('setting_flg') ?></span>
						</div>
					</div>
					<?php $routeData = json_decode($resultList[0]->value); ?>
					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Name <i class="fa fa-asterisk"></i></label>
								<?php $routeData->name = (property_exists($routeData, 'name')) ? $routeData->name : '' ?>
								<input type="text" class="form-control" name="name" autocomplete="off" value="<?= $routeData->name; ?>">
							</div>
							<span class="error"><?= form_error('name') ?></span>
						</div>
					</div>

					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Menu Path </label>
								<?php $routeData->menu_path = (property_exists($routeData, 'menu_path')) ? $routeData->menu_path : '' ?>
								<input type="text" class="form-control" name="menu_path" id="" autocomplete="off" value="<?= $routeData->menu_path; ?>">
							</div>
							<span class="error"><?= form_error('menu_path') ?></span>
						</div>
					</div>

					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Setting Default <small>(Max 25)</small></label>
								<input type="text" class="form-control" name="setting_default" value="<?= $resultList[0]->default; ?>">
							</div>
							<span class="error"><?= form_error('setting_default') ?></span>
						</div>
					</div>
				</div>

				<?php $routeData->route = (property_exists($routeData, 'route')) ? (array) $routeData->route : null; ?>
				<?php $counter = 1; ?>
				<div class="auto_box_area">
					<?php if (is_array($routeData->route)) : ?>
						<?php foreach ($routeData->route as $key => $value) : ?>
							<div class="row auto_box" num="<?= $counter; ?>">
								<div class="col-md-4 col-sm-12 col-xs-12 auto-key">
									<div class="form-group">
										<div class="fg-line">
											<?= ($counter == 1) ? '<label>Route Name</label>' : '' ?>
											<input type="text" name="route[]" class="form-control" value="<?= $key; ?>" placeholder="Route... " required>
										</div>
									</div>
								</div>

								<div class="col-md-7 col-sm-12 col-xs-12 auto-value">
									<div class="form-group">
										<div class="fg-line">
											<?= ($counter == 1) ? '<label>Controller</label>' : '' ?>
											<input type="text" name="controller[]" class="form-control" value="<?= $value; ?>" placeholder="Controller... " required>
										</div>
									</div>
								</div>

								<div class="col-md-1 col-sm-12 col-xs-12 auto-action">
									<div class="form-group">
										<div class="fg-line">
											<a onclick="removeRoute(this.getAttribute('action'))" action="<?= $counter; ?>" class="btn btn-sm btn-danger">
												<i class="fa fa-trash"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							<?php $counter++; ?>
						<?php endforeach ?>
					<?php endif ?>
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
					<?php foreach ($routeData as $key => $value) : ?>
						<?php if (!in_array($key, ['menu_path', 'route', 'name'])) : ?>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<div class="fg-line">
										<label><?= ucwords($key); ?> (Json)</label>
										<?php $key_json = json_encode([$key => $routeData->$key]); ?>
										<textarea class="form-control auto-size" name="asjson[]" autocomplete="off"><?= $key_json; ?></textarea>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
					<span class="error"><?= form_error("asjson") ?></span>
				</div>


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
							<button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Update</button>
						</div>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
