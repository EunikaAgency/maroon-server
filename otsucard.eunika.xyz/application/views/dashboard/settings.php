<div class="card">
    <div class="card-body">
        <p class="h4 m-0 font-weight-bold"><?php echo $title ?></p>
        <p class="m-0 text-muted">Configure your account preferences, security settings, and system options</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header p-3">
                <p class="h4 m-0">
                    <i class="fas fa-lock mr-2"></i> Reset Password
                </p>
            </div>

            <div class="card-body">

                <?php echo form_open('dashboard/settings', ['novalidate' => '', 'class' => 'text-start', 'method' => 'post']); ?>

                <div class="form-group mb-3">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required placeholder="Enter current password">
                    <?php echo form_error('current_password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group mb-3">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required placeholder="Enter new password">
                    <?php echo form_error('new_password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group mb-4">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required placeholder="Confirm new password">
                    <?php echo form_error('confirm_password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill float-right">Update Password</button>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <?php if (is_current_user(HAS_FULL_ACCESS, true) && get_cookie('view_as_user_id')): ?>
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header p-3">
                    <p class="h4 m-0">
                        <i class="fas fa-cogs mr-2"></i> Admin Settings
                    </p>
                </div>

                <div class="card-body">
                    <p class="h4 mb-4">Admin Settings</p>
                    <p>Only visible to admin users.</p>

                    <div class="form-group">
                        <label for="user_role">Set Role</label>
                        <select class="form-control" name="user_role" id="user_role" data-user-id="<?php echo get_current_user_id(); ?>">
                            <?php foreach (USER_ROLES as $role): ?>
                                <option value="<?php echo $role; ?>" <?php echo is_current_user([$role]) ? 'selected' : ''; ?>>
                                    <?php echo ucwords($role); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>