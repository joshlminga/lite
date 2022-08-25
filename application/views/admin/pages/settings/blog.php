<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site page read format | Switch between blog and pages </small></h2>
            </div>

			<!-- Post -->
			<?php $posts = $this->CoreCrud->selectMultipleValue('pages', 'id,title', array('flg' => 1)); ?>

            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_blog, '', ' autocomplete="off" '); ?>

				<div class="row">
				    <div class="col-md-4 col-sm-12">
	        			<?php $home_display = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'home_display']); ?>
				        <div class="form-group">
				            <div class="">
				            	<p><strong>Home Display </strong></p>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="home_display" value="blog" <?= ($home_display == 'blog')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('Blog') ?>
	                            </label>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="home_display" value="page" <?= ($home_display == 'page')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('Static Page') ?>
	                            </label>
				            </div>
	                        <span class="error"><?= form_error("home_display") ?></span>
				        </div>
				    </div>

				    <div class="col-md-4 col-sm-12">
				        <div class="form-group">
				            <div class="">
				            	<p><strong>Home Post</strong></p>
	        					<?php $home_post = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'home_post']); ?>
                                <div class="select">
                                    <select class="selectpicker bs-select-hidden" data-live-search="true" name="home_post" autocomplete="off">
                                    <?php $home_post_list = array('latest_post','old_post','popular_post'); ?>
                                    <?php for ($i = 0; $i < count($home_post_list); $i++): ?>
	                                    <?php if (trim($home_post) == $home_post_list[$i]): ?>
                                    	<option selected="" value="<?= $home_post_list[$i] ?>"><?= ucwords(str_replace("_", " ",$home_post_list[$i]));?> </option>
                                    	<?php else: ?>
                                    	<option value="<?= $home_post_list[$i] ?>"><?= ucwords(str_replace("_", " ",$home_post_list[$i]));?> </option>
	                                    <?php endif ?>
                                    <?php endfor ?>
                                    </select>
                                </div>
				            </div>
				            <span class="error"><?= form_error("home_post") ?></span>
				        </div>
				    </div>

				    <div class="col-md-4 col-sm-12">
				        <div class="form-group">
				            <div class="">
				            	<p><strong>Home Page</strong></p>
	        					<?php $home_page = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'home_page']); ?>
                                <div class="select">
                                    <select class="selectpicker bs-select-hidden" data-live-search="true" name="home_page" autocomplete="off">
                                    	<? $page_title = '';?>
										<?php if (!empty($home_page) && !is_null($home_page)): ?>
											<?php
											$ck_id = trim($home_page);
											$page_title = $this->db->select('page_title')->where('page_id',$home_page)->where('page_flg',1)->get('pages')->row()->page_title;
											?>
	                                    	<option selected="" value="<?= $home_page; ?>"><?= ucwords($page_title); ?></option>
										<?php endif; ?>
                                    	<?php foreach ($posts as $rwpost): ?>
                            				<?php if (trim($rwpost->page_id) != trim($row->setting_value)): ?>
                                        	<option value="<?= strtolower($rwpost->page_id); ?>"><?= ucwords($rwpost->page_title); ?></option>
                                    		<?php endif ?>
                                    	<?php endforeach ?>
                                    </select>
                                </div>
				            </div>
				            <span class="error"><?= form_error("home_page") ?></span>
				        </div>
				    </div>
				</div>

				<div class="row">
				    <div class="col-md-4 col-sm-12">
	        			<?php $post_show = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'post_show']); ?>
				        <div class="form-group">
				            <div class="">
				            	<p><strong>Post Show </strong></p>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="post_show" value="summary" <?= ($post_show == 'summary')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('summary') ?>
	                            </label>
	                            <label class="radio radio-inline m-r-20">
	                                <input type="radio" name="post_show" value="fulltext" <?= ($post_show == 'fulltext')? 'checked' : ''; ?>>
	                                <i class="input-helper"></i> <?= ucwords('fulltext') ?>
	                            </label>
				            </div>
	                        <span class="error"><?= form_error("post_show") ?></span>
				        </div>
				    </div>

				    <div class="col-md-2 col-sm-12">
            			<?php $post_per_page = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'post_per_page']); ?>
				        <div class="form-group">
				            <div class="fg-line">
				            	<label>Post Per Page </label>
				                <input type="text" class="form-control" name="post_per_page" autocomplete="off" value="<?= $post_per_page; ?>">
				            </div>
	                        <span class="error"><?= form_error("post_per_page") ?></span>
				        </div>
				    </div>

				    <div class="col-md-2 col-sm-12">
            			<?php $page_pagination = $this->CoreCrud->selectSingleValue('settings','value',['title' => 'page_pagination']); ?>
				        <div class="form-group">
				            <div class="fg-line">
				            	<label>Page Pagination </label>
				                <input type="text" class="form-control" name="page_pagination" autocomplete="off" value="<?= $page_pagination; ?>">
				            </div>
	                        <span class="error"><?= form_error("page_pagination") ?></span>
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
