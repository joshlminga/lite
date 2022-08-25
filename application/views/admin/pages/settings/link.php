<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Default Current Link customization</small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_link, '', ' autocomplete="off" '); ?>
					<div class="row">

						<div class="col-md-12 col-sm-12">
							<p>Set up default link format. Core CMS uses Post ID number as a default URL format, URL change depends mostly with the use of the platform. Use Post ID if you are developing a system which will enable you to get the matched item ID.</p>
						</div>
					</div>

	            	<?php $value = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'current_url']); ?>
					<div class="row">
					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="radio m-b-15">
					            	<label>
                                    	<input type="radio" name="current_url" value="id" <?= ($value == 'id')? 'checked' : ''; ?>>
	                                    <i class="input-helper"></i>
	                                    <div class="col-md-4 col-sm-12">
	                                    	<p>POST ID</p>
	                                    </div>
	                                    <div class="col-md-8 col-sm-12">
	                                    	<p>Use POST_ID <span style="color: red"><?= site_url('/1') ?></span></p>
	                                    </div>
					            	</label>
					            </div>
					        </div>
					    </div>
					</div>
					
					<div class="row">
					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="radio m-b-15">
					            	<label>
                                    	<input type="radio" name="current_url" value="title" <?= ($value == 'title')? 'checked' : ''; ?>>
	                                    <i class="input-helper"></i>
	                                    <div class="col-md-4 col-sm-12">
	                                    	<p>POST TITLE</p>
	                                    </div>
	                                    <div class="col-md-8 col-sm-12">
	                                    	<p>Use POST_TITLE <span style="color: red"><?= site_url('/post-title') ?></span></p>
	                                    </div>
					            	</label>
					            </div>
					        </div>
					    </div>
				    </div>

					<div class="row">
					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="radio m-b-15">
					            	<label>
                                    	<input type="radio" name="current_url" value="get" <?= ($value == 'get')? 'checked' : ''; ?>>
	                                    <i class="input-helper"></i>
	                                    <div class="col-md-4 col-sm-12">
	                                    	<p>POST GET</p>
	                                    </div>
	                                    <div class="col-md-8 col-sm-12">
	                                    	<p>Use Request <span style="color: red"><?= site_url('/?c=category&p=post-title') ?></span></p>
											<p><small>Kindly note this option works well with blog...</small></p>
	                                    </div>
					            	</label>
					            </div>
					        </div>
					    </div>
				    </div>

					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<div class="fg-line">
			                    	<span class="error"><?= form_error('current_url') ?></span>
								</div>
							</div>
						</div>
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
