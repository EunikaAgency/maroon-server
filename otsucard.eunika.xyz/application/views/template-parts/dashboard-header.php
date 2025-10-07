<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <?php if (get_cookie('view_as_user_id')): ?>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo base_url('auth/logout_preview') ?>" class="nav-link">Logout Preview</a>
            </li>
        <?php endif; ?>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i> Account
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo base_url() ?>">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a class="dropdown-item" href="<?php echo base_url('dashboard/settings') ?>">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>

    </ul>
</nav>