<!-- Field Load Menu -->
<?php $fieldMenu = $this->CoreLoad->menuLoad('field'); ?>

<!-- Field Menu View -->
<?php if (!is_null($fieldMenu)): ?>
	<?php foreach ($fieldMenu as $key => $menu_path): ?>
	    <!-- Field -->
	    <?php $this->load->view("extend/customfields/$menu_path"); ?>
	    <!-- End Field -->
	<?php endforeach ?>
<?php endif ?>
