<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($Module); ?> <small>Creat / Add new <?= strtolower($Module); ?></small></h2>
            </div>

            <div class="card-body card-padding">

				<div class="row">
					<h3><?=  $list[2]['datetime'] ?></h3>
					<pre>
						<?php print_r($list); ?>
					</pre>
				</div>
			</div>
		</div>
	</div>
</section>
