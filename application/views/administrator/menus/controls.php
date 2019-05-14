<!-- Control Load Menu -->
<?php $controlMenu = $this->CoreLoad->menuLoad('control'); ?>

<!-- Loop Menu View -->
<?php if (!is_null($controlMenu)): ?>
	<?php foreach ($controlMenu as $key => $menu_path): ?>
	    <!-- Control -->
	    <?php $this->load->view("administrator/pages/$menu_path"); ?>
	    <!-- End Control -->
	<?php endforeach ?>
<?php endif ?>
