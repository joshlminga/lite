<?php if ($this->CoreLoad->auth('migrate')) : ?>
	<li class="sub-menu">
		<!-- active -->
		<a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-collection-item-9 zmdi-hc-fw color-yellow"></i> Migrate </a>
		<ul>
			<li class=""><a href="<?= site_url('migrate') ?>">All</a></li>
			<li class=""><a href="<?= site_url('migrate/blog') ?>">Blog</a></li>
			<li class=""><a href="<?= site_url('migrate/page') ?>">Page</a></li>
			<li class=""><a href="<?= site_url('migrate/autofield') ?>">Autofield</a></li>
			<li class=""><a href="<?= site_url('migrate/inheritance') ?>">Inheritance</a></li>
			<li class=""><a href="<?= site_url('migrate/customfield') ?>">Customfield</a></li>
			<li class=""><a href="<?= site_url('migrate/field') ?>">Field</a></li>
			<li class=""><a href="<?= site_url('migrate/fieldgroup') ?>">Field Group</a></li>
			<li class=""><a href="<?= site_url('migrate/level') ?>">Level</a></li>
			<li class=""><a href="<?= site_url('migrate/user') ?>">User</a></li>
		</ul>
	</li>
<?php endif ?>
