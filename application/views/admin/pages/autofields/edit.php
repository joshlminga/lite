<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
				<p><strong>Meta URL:</strong> <?= $met_url; ?></p>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
				<div class="row">
					<input type="hidden" name="id" value="<?= $resultList[0]->id; ?>">
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
								<input type="text" class="form-control" id="" autocomplete="off" disabled="" value="<?= ucwords(str_replace("_", " ", stripcslashes($resultList[0]->title))); ?>">
							</div>
							<p style="color:#0a10f0;font-size:11px"><?= $resultList[0]->title; ?></p>
						</div>
					</div>

					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Select Type <small>(Type Identifier)</small> </label>
								<input type="text" class="form-control" name="autofield_select" id="" autocomplete="off" value="<?= ucwords(str_replace("_", " ", stripcslashes($resultList[0]->select))); ?>">
							</div>
							<span class="error"><?= form_error('autofield_select') ?></span>
						</div>
					</div>
				</div>

				<?php $itemData = json_decode($resultList[0]->data, True); ?>
				<div class="auto_box_area">
					<?php $counter = 1; ?>
					<?php if (is_array($itemData)) : ?>
						<?php foreach ($itemData as $key => $value) : ?>
							<div class="row auto_box" num="<?= $counter; ?>">
								<div class="col-md-4 col-sm-12 col-xs-12 auto-key">
									<div class="form-group">
										<div class="fg-line">
											<label>Label/Key Unique Name <i class="fa fa-asterisk"></i> </label>
											<input type="text" name="autofield_label[]" class="form-control" value="<?= stripcslashes(ucwords(str_replace("_", " ", $key))); ?>" placeholder="Label/Key... " required>
										</div>
										<p style="color:#0a10f0;font-size:11px"><?= $key; ?></p>
									</div>
								</div>

								<div class="col-md-7 col-sm-12 col-xs-12 auto-value">
									<div class="form-group">
										<div class="fg-line">
											<label>Data/Value </label>
											<textarea name="autofield_value[]" class="form-control auto-size" placeholder="Data/Value... "><?= stripcslashes($value); ?></textarea>
										</div>
									</div>
								</div>

								<div class="col-md-1 col-sm-12 col-xs-12 auto-action">
									<div class="form-group">
										<div class="fg-line">
											<a onclick="removeAutoData(this.getAttribute('action'))" action="<?= $counter; ?>" class="btn btn-sm btn-danger">
												Remove<i class="fa fa-trash"></i>
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
							<button type="button" onclick="addAutoData()" class="btn btn-success btn-xs waves-effect">
								Add Fields +
							</button>

							<button type="button" onclick="removeAutoData()" class="btn btn-danger btn-xs waves-effect">
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
