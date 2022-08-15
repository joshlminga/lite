<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords('Migrate Table Data'); ?> </h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_save, '', ' autocomplete="off" '); ?>

				<div class="row">
					<div class="col-md-12 col-ms-12 col-xs-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Module </label>
								<?php for ($i = 0; $i < count($moduleList); $i++) : ?>
									<div class="checkbox">
										<label class="checkbox checkbox-inline m-r-20">
											<input type="checkbox" name="migrate[]" value="<?= strtolower($moduleList[$i]) ?>">
											<i class="input-helper"></i>
											<?= ucwords($moduleList[$i]) ?>
										</label>
									</div>
								<?php endfor ?>
							</div>
							<span class="error"><?= form_error('migrate') ?></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Migrate</button>
						</div>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
