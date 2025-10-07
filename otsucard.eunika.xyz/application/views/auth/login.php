<div class="container loginContainer min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-sm">
        <div class="card-body">

            <a href="<?php echo LIVE_SITE_URL ?>">
                <img src="<?php echo base_url('src/images/otsuka-full-logo.png') ?>" class="d-block mx-auto mb-4">
            </a>

            <h2 class="text-center mb-4">Login</h2>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open('auth/login', ['novalidate' => '', 'class' => 'text-start', 'method' => 'post']); ?>

            <div class="mb-3">
                <label for="username" class="form-label">Username / Email</label>
                <input type="text" class="form-control <?php echo form_error('username') ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Enter your username or email">
                <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Enter your password">
                <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

            <?php echo form_close(); ?>

            <p class="text-center">
                <a href="<?php echo base_url('forgot_password') ?>">Forgot Password</a>
            </p>

        </div>
    </div>
</div>
