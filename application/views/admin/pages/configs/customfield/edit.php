<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($Module); ?> <small>Edit / Update <?= strtolower($Module); ?></small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify)) ? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
				<div class="row">
					<input type="hidden" name="id" value="<?= $resultList[0]->id; ?>">
					<div class="col-md-5 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
								<input type="text" class="form-control" autocomplete="off" disabled="" value="<?= $resultList[0]->title; ?>">
							</div>

							<p><strong>Table Name</strong> : <span style="color:#0a10f0;font-size:13px"><?= $this->plural->pluralize($resultList[0]->title); ?></span></p>
						</div>
					</div>
				</div>

				<?php $inputs = json_decode($resultList[0]->inputs, True); ?>
				<?php $filters = json_decode($resultList[0]->filters, True); ?>
				<?php $keys = json_decode($resultList[0]->keys, True); ?>

				<!-- Fields -->
				<div class="row">
					<div class="field_box_area">
						<?php if (is_array($inputs)) : ?>
							<?php $counter = 1; ?>
							<?php foreach ($inputs as $key => $value) : ?>
								<div class="col-md-3 col-sm-12 field-key" num="<?= $counter; ?>">
									<div class="form-group">
										<div class="fg-line">
											<label>
												Key <small>(Unique Name)</small>

												<a onclick="removeField(this.getAttribute('action'))" action="<?= $counter; ?>" class="btn btn-sm btn-danger field-action">
													<i class="fa fa-trash"></i>
												</a>
												<?php
												$clean = preg_replace("/[^ \w-]/", "", trim($value));
												$clean_input = preg_replace('/-+/', '-', $clean);

												// Replace - & space with _
												$filter_value = strtolower(str_replace("-", "_", str_replace(" ", "_", trim($clean_input))));
												?>
												<?php $checked = (in_array($filter_value, $filters)) ? ' checked ' : ' '; ?>
												<input <?= $checked; ?> type="checkbox" name="filter_<?= $counter; ?>" value="<?= $counter; ?>"><i class="input-helper"></i>Filter
											</label>
											<input type="text" class="form-control" name="customfield_inputs[]" autocomplete="off" value="<?= stripcslashes($value); ?>" required>
										</div>
										<p style="color:#0a10f0;font-size:11px"><?= $filter_value; ?></p>
									</div>
								</div>
								<?php $counter++; ?>
							<?php endforeach ?>
						<?php endif ?>
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
							<button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Update</button>
						</div>
					</div>
				</div>

				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
