

    <?php if ($this->CoreLoad->auth('customers')): ?>
    <li class="sub-menu"> <!-- active -->
        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-pin-account zmdi-hc-fw blue"></i> Customer </a>
        <ul>
            <li class=""><a href="<?= site_url('customers/new') ?>">New</a></li>
            <li class=""><a href="<?= site_url('customers') ?>">Manage</a></li>
        </ul>
    </li>
    <?php endif ?>
