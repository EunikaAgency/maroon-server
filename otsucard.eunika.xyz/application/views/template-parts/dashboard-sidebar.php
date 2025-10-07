<?php
// $user_logo = is_user_logged_in() ? get_avatar_url(get_current_user_id()) : '';
?>

<aside class="main-sidebar elevation-4 sidebar-light-primary">

    <a href="<?php echo base_url() ?>" class="brand-link">
        <img src="<?php echo base_url('src/images/otsuka-logo.png') ?>" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">Otsuka HCP</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- <?php if (is_current_user(HAS_FULL_ACCESS)): ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>" class="nav-link <?php echo $active_tab == 'overview' ? 'active' : '' ?>">
                            <i class="nav-icon far fa-image"></i>
                            <p>
                                Overview
                            </p>
                        </a>
                    </li>
                <?php endif; ?> -->

                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/card') ?>" class="nav-link rounded-pill <?php echo $active_tab == 'card' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Card
                        </p>
                    </a>
                </li>

                <?php if (is_current_user(HAS_FULL_ACCESS)): ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('dashboard/cards') ?>" class="nav-link rounded-pill <?php echo $active_tab == 'cards' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>
                                Cards (Administrator)
                            </p>
                        </a>
                    </li>
                <?php endif; ?>


                <li class="nav-item">
                    <a href="<?php echo base_url('dashboard/settings') ?>" class="nav-link rounded-pill <?php echo $active_tab == 'settings' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>