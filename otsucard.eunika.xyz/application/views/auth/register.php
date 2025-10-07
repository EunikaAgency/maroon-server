<div class="container registrationContainer min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card">
        <div class="card-body">

            <a href="<?php echo LIVE_SITE_URL ?>">
                <img src="<?php echo base_url('src/images/otsuka-full-logo.png') ?>" class="d-block mx-auto mb-4">
            </a>

            <h2 class="text-center mb-4">
                <?php
                if ($this->session->flashdata('skip_validation')) {
                    echo 'Register now to activate the card';
                } else {
                    echo 'Register';
                }
                ?></h2>

            <?php echo form_open('auth/register', ['class' => 'needs-validation', 'novalidate' => '', 'method' => 'post']); ?>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="activation" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="activation" name="activation"
                            value="<?php echo set_value('activation', isset($activation) ? $activation : ''); ?>" readonly placeholder="Your card number">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?php echo form_error('username') ? 'is-invalid' : ''; ?>"
                            id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Enter username">
                        <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>"
                            id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Enter email address">
                        <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>"
                            id="password" name="password" placeholder="Enter password">
                        <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?php echo form_error('confirm_password') ? 'is-invalid' : ''; ?>"
                            id="confirm_password" name="confirm_password" placeholder="Re-enter password">
                        <?php echo form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>

            <?php echo form_close(); ?>

            <p class="text-center">Already have an account? <a href="<?php echo base_url() ?>">Login</a></p>

        </div>
    </div>

</div>