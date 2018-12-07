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
					            	<label>Type Name <small>(E.g. Location)</small> <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" name="customfield_type" id="" autocomplete="off" value="<?= set_value('customfield_type'); ?>">
					            </div>
					            <span class="error"><?= form_error('customfield_type') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Parent <small>(E.g. County)</small><i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="customfield_parent" id="" autocomplete="off" value="<?= set_value('customfield_parent'); ?>">
					            </div>
					            <span class="error"><?= form_error('customfield_parent') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12 optional" id="optional">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Sub Children Name <small>(E.g City,War,Town e.t.c | Add more)</small></label>
					                <input type="text" class="form-control" name="customfield_child[]" id="" autocomplete="off" value="<?= set_value('customfield_child'); ?>">
					            </div>
					            <span class="error"><?= form_error('customfield_child') ?></span>
					        </div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-md-6 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="duplicateData('optional')" class="btn btn-success btn-xs waves-effect">
			                		Add Custom Fields +
			                	</button>
			                	<button type="button" onclick="removeData('optional')" class="btn btn-danger btn-xs waves-effect">
			                		Remove Custom Fields -
			                	</button>
					        </div>
					    </div>
					    <div class="col-md-6 col-sm-12">
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
