<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_save, ' autocomplete="off" '); ?>
					<div class="row">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_name" id="" autocomplete="off" value="<?= set_value('user_name'); ?>">
					            </div>
					            <span class="error"><?= form_error('user_name') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Email <i class="fa fa-asterisk"></i></label>
					                <input type="email" class="form-control" name="user_email" id="" autocomplete="off" value="<?= set_value('user_email'); ?>">
					            </div>
					            <span class="error"><?= form_error('user_email') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Level <i class="fa fa-asterisk"></i></label>
	                                <div class="select">
	                                    <select class="form-control" name="user_level" autocomplete="off">
	                                    	<?php foreach ($level as $row): ?>
	                                        	<option value="<?= strtolower($row->level_name); ?>"><?= ucwords($row->level_name); ?></option>
	                                    	<?php endforeach ?>
	                                    </select>
	                                </div>
					            </div>
					            <span class="error"><?= form_error('user_level') ?></span>
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Logname <small>(login/user name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_logname" id="" autocomplete="off" value="<?= set_value('user_logname'); ?>">
					            </div>
					            <span class="error"><?= form_error('user_logname') ?></span>
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Password <i class="fa fa-asterisk"></i></label>
					                <input type="password" class="form-control" name="user_password" id="" autocomplete="new-password"
					                value="<?= set_value('user_password'); ?>">
					            </div>
					            <span class="error"><?= form_error('user_password') ?></span>
					        </div>
					    </div>

					    <div class="col-md-12 col-sm-12">
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
