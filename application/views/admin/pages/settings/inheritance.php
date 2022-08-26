<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords('General Settings'); ?> <small>Inheritance Type | Setup </small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_inheritance, '', ' autocomplete="off" '); ?>
				<div class="row">
					<div class="col-md-5 col-sm-12">
						<?php $inheritance_data = $this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'inheritance_data']); ?>
						<div class="form-group">
							<div class="fg-line">
								<label>Inheritance Data Type</label>
								<textarea class="form-control auto-size" autocomplete="off" name="inheritance_data"><?= $inheritance_data; ?></textarea>
							</div>
							<span class="error"><?= form_error("inheritance_data") ?></span>
						</div>

						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Update</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-7 col-sm-12">
						<div class="table-responsive">
							<!-- Decode -->
							<?php $info_inheritance_data = explode(',', $inheritance_data); ?>
							<?php $count = 1; ?>
							<table id="data-table-basic" class="table table-striped">
								<thead>
									<tr>
										<th data-column-id="id" data-type="numeric">No</th>
										<th data-column-id="title">Title</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($info_inheritance_data as $key => $value) : ?>
										<tr>
											<td><?= $key; ?></td>
											<td><?= $value; ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
