<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site page read format | Switch between blog and pages </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_blog, '', ' autocomplete="off" '); ?>
					<div class="row">


						<?php foreach ($resultList as $row): ?>
							<?php if ($row->setting_title == 'home_display'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="home_display" value="blog"
			                                <?= ($row->setting_value == 'blog')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('Latest Blog') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="home_display" value="page" 
			                                <?= ($row->setting_value == 'page')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('Static Page') ?>
			                            </label>
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
	                        <?php elseif ($row->setting_title == 'post_show'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="post_show" value="blog"
			                                <?= ($row->setting_value == 'summary')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('summary') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="post_show" value="fulltext" 
			                                <?= ($row->setting_value == 'fulltext')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('fulltext') ?>
			                            </label>
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
	                        <?php else: ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?></label>
						                <input type="text" class="form-control" name="<?= $row->setting_title;?>" id="" autocomplete="off" 
						                value="<?= $row->setting_value; ?>">
						            </div>
			                        <span class="error"><?= form_error("$row->setting_title") ?></span>
						        </div>
						    </div>
							<?php endif ?>
						<?php endforeach ?>
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
