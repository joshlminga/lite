<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
					<div class="row">
						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_name" id="" autocomplete="off" value="<?= $resultList[0]->name; ?>">
					            </div>
					            <span class="error"><?= form_error('user_name') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Email <i class="fa fa-asterisk"></i></label>
					                <input type="email" class="form-control" name="user_email" id="" autocomplete="off" value="<?= $resultList[0]->email; ?>">
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
	                                    	<option selected="" value="<?= strtolower($resultList[0]->level); ?>"><?= ucwords($resultList[0]->level); ?></option>
	                                    	<?php foreach ($level as $row): ?>
	                                    		<?php if (strtolower($resultList[0]->level) != strtolower($row->level_name)): ?>
	                                        	<option value="<?= strtolower($row->level_name); ?>"><?= ucwords($row->level_name); ?></option>
	                                    		<?php endif ?>
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
					                <input type="text" class="form-control" name="user_logname" autocomplete="off" value="<?= $resultList[0]->logname; ?>">
					            </div>
					            <span class="error"><?= form_error('user_logname') ?></span>
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>New Password </label>
					                <input type="text" class="form-control" name="user_password" autocomplete="off" value="">
					            </div>
					            <span class="error"><?= form_error('user_password') ?></span>
					        </div>
					    </div>

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
