<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($Module); ?> <small>Creat / Add new <?= strtolower($Module); ?></small></h2>
            </div>

            <div class="card-body card-padding">

				<div class="row">

				    <div class="<?= $col_class; ?>">
				        <div class="form-group">
				            <div class="fg-line <?= $input_name.'-class'; ?>">
				            	<label><?= $label_name; ?></label>
				                <input type="<?= $input_type; ?>" class="form-control <?= $input_class; ?>" name="<?= $input_name; ?>" 
				                id="<?= $input_name.'-1'; ?>">
				            </div>
				        </div>
				    </div>

				</div>
			</div>
		</div>
	</div>
</section>
