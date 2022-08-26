<?php if ($this->CoreLoad->auth('customer')) : ?>
	<li class="sub-menu">
		<!-- active -->
		<a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-pin-account zmdi-hc-fw color-light-green"></i> Customer </a>
		<ul>
			<li class=""><a href="<?= site_url('customer/new') ?>">New</a></li>
			<li class=""><a href="<?= site_url('customer') ?>">Manage</a></li>
		</ul>
	</li>
<?php endif ?>
