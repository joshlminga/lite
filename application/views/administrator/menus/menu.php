<!-- Load Menu -->
<?php $loadMenu = $this->CoreLoad->menuLoad('menu'); ?>

<!-- Menu View -->
<?php if (!is_null($loadMenu)): ?>
    <?php foreach ($loadMenu as $key => $menu_path): ?>
        <!-- Menu -->
        <?php $this->load->view("extend/$menu_path"); ?>
        <!-- End Menu -->
    <?php endforeach ?>
<?php endif ?>
