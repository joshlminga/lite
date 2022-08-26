<?php if ($this->CoreLoad->auth('member')) : ?>
	<li class="sub-menu">
		<!-- active -->
		<a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment zmdi-hc-fw color-gray"></i>
			Field Members
		</a>
		<ul>
			<li class=""><a href="<?= site_url('member/new') ?>">New</a></li>
			<li class=""><a href="<?= site_url('member') ?>">Manage</a></li>
		</ul>
	</li>
<?php endif ?>
