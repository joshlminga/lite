<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
			</div>

			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<form class="" role="form" action="<?= site_url($form_save) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
					<input type="hidden" name="id" value="<?= $fieldList[0]->id; ?>">

					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label>Name <i class="fa fa-asterisk"></i></label>
									<input type="text" name="name" class="form-control" value="<?= set_value('name'); ?>" placeholder="Full Name">
								</div>
								<span class="error"><?= form_error('name') ?></span>
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label>Email <i class="fa fa-asterisk"></i></label>
									<input type="email" name="email" class="form-control" value="<?= set_value('email'); ?>" placeholder="Email Address">
								</div>
								<span class="error"><?= form_error('email') ?></span>
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<div class="fg-line">
									<label>Mobile Number <small>(e.g 07XXXXXXXX)</small> <i class="fa fa-asterisk"></i></label>
									<input type="text" name="mobile" class="form-control" value="<?= set_value('mobile'); ?>" placeholder="07XXXXXXXX" require>
								</div>
								<span class="error"><?= form_error('mobile') ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-12">
							<div class="fg-line">
								<label>Gender </label>
								<select name="gender" class="selectpicker" data-placeholder="Choose Gender...">
									<?php for ($i = 0; $i < count($gender); $i++) : ?>
										<option value="<?= strtolower($gender[$i]->inheritance_id) ?>"><?= ucwords($gender[$i]->inheritance_title) ?></option>
									<?php endfor ?>
								</select>
							</div>
							<span class="error"><?= form_error('gender') ?></span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
