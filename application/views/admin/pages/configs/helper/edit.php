<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_edit, ' autocomplete="off" '); ?>
				<input type="hidden" name="id" value="<?= $resultList[0]->id; ?>">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Title <small>(Unique Name)</small> <i class="fa fa-asterisk"></i></label>
								<input type="text" class="form-control" name="setting_title" autocomplete="off" value="<?= $resultList[0]->title; ?>" required>
							</div>
							<span class="error"><?= form_error('setting_title') ?></span>
						</div>
					</div>

					<div class="col-md-2 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Type <small>(Max 25 char)</small> </label>
								<?php $default = set_value('setting_default'); ?>
								<?php $default = (!is_null($default) && !empty($default)) ? $default : $resultList[0]->default; ?>
								<input type="text" class="form-control" name="setting_default" autocomplete="off" value="<?= $default; ?>">
							</div>
							<span class="error"><?= form_error('setting_default') ?></span>
						</div>
					</div>

					<?php $valueArray = json_decode($resultList[0]->value); ?>
					<?php
					// Values
					$general_key = null;
					$general_value = $resultList[0]->value;
					if (is_array($valueArray)) {
						// Check if is index base or key base array
						if (array_keys($valueArray) == range(0, count($valueArray) - 1)) {
							$general_key = $valueArray;
							$general_value = '';
						}
					}
					?>

					<div class="col-md-7 col-sm-12 col-xs-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Data As String/Json (<small class="color-red">If you add data here will overide 'Entry Value' section</small>) </label>
								<textarea name="general_value" class="form-control auto-size" placeholder='String or {"key":"value"} or ["value1","value2"]'><?= $general_value; ?></textarea>
								<span class="error"><?= form_error('general_value') ?></span>
							</div>
						</div>
					</div>
				</div>

				<!-- As Keys -->
				<div class="row">
					<div class="col-md-12">
						<div class="fg-line">
							<label class="color-red"><?= form_error('general_key[]') ?></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="helper_box_area">
						<?php if (is_array($general_key)) : ?>
							<?php $counter = 1; ?>
							<?php foreach ($general_key as $key => $value) : ?>
								<div class="col-md-3 col-sm-12 field-key" num="<?= $counter; ?>">
									<div class="form-group">
										<div class="fg-line">
											<label>
												Entry Value
												<a onclick="removeHelper(this.getAttribute('action'))" action="<?= $counter; ?>" class="btn btn-sm btn-danger field-action">
													<i class="fa fa-trash"></i>
												</a>
											</label>
											<input type="text" class="form-control" name="general_key[]" autocomplete="off" value="<?= $value; ?>">
										</div>
									</div>
								</div>
								<?php $counter++; ?>
							<?php endforeach ?>
						<?php else : ?>
							<div class="col-md-3 col-sm-12 field-key" num="1">
								<div class="form-group">
									<div class="fg-line">
										<label>
											Entry Value
											<a onclick="removeHelper(this.getAttribute('action'))" action="1" class="btn btn-sm btn-danger field-action">
												<i class="fa fa-trash"></i>
											</a>
										</label>
										<input type="text" class="form-control" name="general_key[]" autocomplete="off" value="">
									</div>
								</div>
							</div>
						<?php endif ?>
					</div>
				</div>


				<div class="row">
					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<button type="button" onclick="addHelper()" class="btn btn-success btn-xs waves-effect">
								Add Fields +
							</button>

							<button type="button" onclick="removeHelper()" class="btn btn-danger btn-xs waves-effect">
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
