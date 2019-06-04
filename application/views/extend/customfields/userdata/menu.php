

<?php if ($this->CoreLoad->auth('userdatas')): ?>
<li class="sub-menu"> <!-- active -->
    <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment zmdi-hc-fw red_less"></i> 
        Field Control User 
    </a>
    <ul>
        <li class=""><a href="<?= site_url('userdatas/new') ?>">New</a></li>
        <li class=""><a href="<?= site_url('userdatas') ?>">Manage</a></li>
    </ul>
</li>
<?php endif ?>
