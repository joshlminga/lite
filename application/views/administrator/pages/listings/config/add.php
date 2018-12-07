<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($Module); ?> <small>Creat / Add new <?= strtolower($Module); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_save, ' autocomplete="off" '); ?>
					<div class="row">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" name="listing_title" id="" autocomplete="off" value="<?= set_value('listing_title'); ?>">
					            </div>
					            <span class="error"><?= form_error('listing_title') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12 required" id="required">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Required <small>(Required Fields)</small><i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="listing_required[]" id="" autocomplete="off" value="<?= set_value('listing_required'); ?>">
					            </div>
					            <span class="error"><?= form_error('listing_required') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12 optional" id="optional">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Optional <small>(Optional Fields)</small></label>
					                <input type="text" class="form-control" name="listing_optional[]" id="" autocomplete="off" value="<?= set_value('listing_optional'); ?>">
					            </div>
					            <span class="error"><?= form_error('listing_optional') ?></span>
					        </div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-md-4 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="duplicateData('required')" class="btn btn-success btn-xs waves-effect">
			                		Add Required Fields +
			                	</button>

			                	<button type="button" onclick="removeData('required')" class="btn btn-danger btn-xs waves-effect">
			                		Remove Required Fields -
			                	</button>
					        </div>
					    </div>
					    <div class="col-md-4 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="duplicateData('optional')" class="btn btn-success btn-xs waves-effect">
			                		Add Optional Fields +
			                	</button>
			                	<button type="button" onclick="removeData('optional')" class="btn btn-danger btn-xs waves-effect">
			                		Remove Optional Fields -
			                	</button>
					        </div>
					    </div>
					    <div class="col-md-4 col-sm-12">
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
