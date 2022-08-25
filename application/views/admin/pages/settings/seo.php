<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site default Search Engine Optinization Global Configurations  </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_seo, '', ' autocomplete="off" '); ?>

				<div class="row">
				    <div class="col-md-4 col-sm-12">
	        			<?php $seo_visibility = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'seo_visibility']); ?>
				        <div class="form-group">
				            <div class="">
				            	<p><strong>Seo Visibility</strong></p>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="seo_visibility" value="noindex, nofollow" <?= ($seo_visibility == 'noindex, nofollow')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('Hide my site') ?>
	                            </label>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="seo_visibility" value="index, follow" <?= ($seo_visibility == 'index, follow')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('Show my site') ?>
	                            </label>
				            </div>
	                        <span class="error"><?= form_error("seo_visibility") ?></span>
				        </div>
				    </div>

				    <div class="col-md-4 col-sm-12">
	        			<?php $seo_global = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'seo_global']); ?>
				        <div class="form-group">
				            <div class="">
				            	<p><strong>Seo Global</strong></p>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="seo_global" value="any" <?= ($seo_global == 'any')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('to all Pages') ?>
	                            </label>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="seo_global" value="home" <?= ($seo_global == 'home')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('Only Home Page') ?>
	                            </label>
				            </div>
	                        <span class="error"><?= form_error("seo_global") ?></span>
				        </div>
				    </div>
				</div>

				<div class="row">
				    <div class="col-md-12 col-sm-12">
				        <div class="form-group">
				            <div class="fg-line">
				            	<label>Seo Description</label>
	        					<?php $seo_description = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'seo_description']); ?>
		                        <textarea class="form-control auto-size" name="seo_description" autocomplete="off"><?= $seo_description; ?></textarea>
				            </div>
	                        <span class="error"><?= form_error("seo_description") ?></span>
				        </div>
				    </div>
				</div>

				<div class="row">
				    <div class="col-md-12 col-sm-12">
				        <div class="form-group">
				            <div class="fg-line">
				            	<label>Seo Keywords</label>
	        					<?php $seo_keywords = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'seo_keywords']); ?>
		                        <textarea class="form-control auto-size" name="seo_keywords" autocomplete="off"><?= $seo_keywords; ?></textarea>
				            </div>
	                        <span class="error"><?= form_error("seo_keywords") ?></span>
				        </div>
				    </div>
				</div>

				<div class="row">
				    <div class="col-md-12 col-sm-12">
				        <div class="form-group">
				            <div class="fg-line">
				            	<label>Seo Meta Data</label>
	        					<?php $seo_meta_data = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'seo_meta_data']); ?>
		                        <textarea class="form-control auto-size" name="seo_meta_data" autocomplete="off"><?= $seo_meta_data; ?></textarea>
				            </div>
	                        <span class="error"><?= form_error("seo_meta_data") ?></span>
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
