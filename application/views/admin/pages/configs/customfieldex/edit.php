<section id="content">
	<div class="container">
		<div class="card">
			<div class="card-header">
				<h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
			</div>


			<div class="card-body card-padding">
				<!-- Notification -->
				<?= (!is_null($notify) && !empty($notify) && $notify != 'blank') ? $notify : ''; ?>
				<?= form_open($form_edit, ' autocomplete="off" '); ?>

				<input type="hidden" name="id" value="<?= $resultList[0]->id; ?>">

				<?php $data = json_decode($resultList[0]->data); ?>

				<?php $inputs = json_decode($fieldList[0]->inputs, True); ?>
				<?php $filters = json_decode($fieldList[0]->filters, True); ?>
				<?php $keys = json_decode($fieldList[0]->keys, True); ?>

				<div class="row">
					<?php foreach ($inputs as $index => $value): ?> 
					<div class="col-md-6 col-sm-12">
						<div class="form-group">
							<div class="fg-line">
								<?php
								$clean = preg_replace("/[^ \w-]/", "", trim($value));
								$clean_input = preg_replace('/-+/', '-', $clean);

								// Replace - & space with _
								$filter_value = strtolower(str_replace("-", "_", str_replace(" ", "_", trim($clean_input))));
								?>
								<?php $required = (in_array($filter_value, $filters)) ? true : false; ?>

								<label><?= stripcslashes($value); ?> 
									<?= ($required) ? '<i class="fa fa-asterisk"></i>' : ''; ?>
								</label>
								<input type="text" <?= ($required) ? 'required' : ''; ?> class="form-control" name="<?= $filter_value; ?>" 
								value="<?= $data->$filter_value; ?>">
							</div>
						</div>
					</div>
					<?php endforeach; ?>
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
