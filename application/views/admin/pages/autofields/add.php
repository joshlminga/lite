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
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
								<input type="text" class="form-control" name="autofield_title" id="" autocomplete="off" value="<?= set_value('autofield_title'); ?>" required>
							</div>
							<span class="error"><?= form_error('autofield_title') ?></span>
						</div>
					</div>

					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Select Type <small>(Type Identifier)</small> </label>
								<input type="text" class="form-control" name="autofield_select" id="" autocomplete="off" value="<?= set_value('autofield_select'); ?>">
							</div>
							<span class="error"><?= form_error('autofield_select') ?></span>
						</div>
					</div>
				</div>
				<div class="auto_box_area">
					<div class="row auto_box" num="1">
						<div class="col-md-4 col-sm-12 col-xs-12 auto-key">
							<div class="form-group">
								<div class="fg-line">
									<label>Label/Key Unique Name <i class="fa fa-asterisk"></i> </label>
									<input type="text" name="autofield_label[]" class="form-control" value="" placeholder="Label/Key... " required>
								</div>
							</div>
						</div>

						<div class="col-md-7 col-sm-12 col-xs-12 auto-value">
							<div class="form-group">
								<div class="fg-line">
									<label>Data/Value </label>
									<textarea name="autofield_value[]" class="form-control auto-size" placeholder="Data/Value... "><?= set_value('autofield_value'); ?></textarea>
								</div>
							</div>
						</div>


						<div class="col-md-1 col-sm-12 col-xs-12 auto-action">
							<div class="form-group">
								<div class="fg-line">
									<a onclick="removeAutoData(this.getAttribute('action'))" action="1" class="btn btn-sm btn-danger">
										Remove<i class="fa fa-trash"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
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
							<button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Save</button>
						</div>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
