<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Creat / Add new <?= strtolower($ModuleName); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_save, ' autocomplete="off" '); ?>
					<div class="row">
					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" name="autofield_title" id="" autocomplete="off" value="<?= set_value('autofield_title'); ?>">
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
					<div class="row">
					    <div class="col-md-6 col-sm-12 labelItem" id="itemLabel">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Item Label </label>
					                <input type="text" class="form-control" name="autofield_label[]" id="" autocomplete="off" value="<?= set_value('autofield_label'); ?>">
					            </div>
					            <span class="error"><?= form_error('autofield_label') ?></span>
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12 valueItem" id="itemValue">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Item Value </label>
					                <input type="text" class="form-control" name="autofield_value[]" id="" autocomplete="off" value="<?= set_value('autofield_value'); ?>">
					            </div>
					            <span class="error"><?= form_error('autofield_value') ?></span>
					        </div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-md-4 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="autoaddData()" class="btn btn-success btn-xs waves-effect">
			                		Add Fields +
			                	</button>

			                	<button type="button" onclick="autoremoveData()" class="btn btn-danger btn-xs waves-effect">
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
