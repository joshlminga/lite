<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_save, ' autocomplete="off" '); ?>
				<div class="row">
					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
								<input type="text" class="form-control" name="customfield_title" id="" autocomplete="off" value="<?= set_value('customfield_title'); ?>">
							</div>
							<span class="error"><?= form_error('customfield_title') ?></span>
						</div>
					</div>
				</div>

				<!-- Fields -->
				<div class="row">
					<div class="field_box_area">
						<div class="col-md-3 col-sm-12 field-key" num="1">
							<div class="form-group">
								<div class="fg-line">
									<label>
										Key <small>(Unique Name)</small>

										<a onclick="removeField(this.getAttribute('action'))" action="1" class="btn btn-sm btn-danger field-action">
											<i class="fa fa-trash"></i>
										</a>

										<input type="checkbox" name="filter_1" value="1"><i class="input-helper"></i>Filter
									</label>
									<input type="text" class="form-control" name="customfield_inputs[]" autocomplete="off" value="<?= set_value('customfield_inputs'); ?>" required>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 col-sm-12">
						<div class="form-group">
							<button type="button" onclick="addField()" class="btn btn-success btn-xs waves-effect">
								Add Field +
							</button>

							<button type="button" onclick="removeField()" class="btn btn-danger btn-xs waves-effect">
								Remove Field -
							</button>
						</div>
					</div>

					<div class="col-md-8 col-sm-12">
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
