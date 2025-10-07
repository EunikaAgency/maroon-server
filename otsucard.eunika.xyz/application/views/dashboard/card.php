<div class="card">
    <div class="card-body">
        <p class="h4 m-0 font-weight-bold"><?php echo $title ?></p>
        <p class="m-0 text-muted">Update and manage your professional identification card information</p>
    </div>
</div>

<?php if ($card): ?>

    <?php $card_profile_link = base_url('user/profile/' . $card->card_number);  ?>

    <?php echo form_open_multipart('dashboard/card', ['novalidate' => '', 'class' => 'text-start', 'method' => 'post']); ?>
    <div class="row">
        <div class="col-md-8">

            <div class="card card-primary">
                <div class="card-header p-3">
                    <p class="h4 m-0">
                        <i class="fas fa-user mr-2"></i> Personal Information
                    </p>
                </div>

                <div class="card-body">

                    <p>
                        <strong>View Profile:</strong> <a href="<?php echo $card_profile_link ?>" target="_blank"><?php echo $card_profile_link ?></a>
                    </p>


                    <input type="hidden" name="id" value="<?php echo $card->id; ?>">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" class="form-control <?php echo form_error('card_number') ? 'is-invalid' : ''; ?>" id="card_number" name="card_number" value="<?php echo $card->card_number; ?>" disabled>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control <?php echo form_error('firstname') ? 'is-invalid' : ''; ?>" id="firstname" name="firstname" value="<?php echo set_value('firstname', $card->firstname); ?>">
                            <?php echo form_error('firstname', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control <?php echo form_error('lastname') ? 'is-invalid' : ''; ?>" id="lastname" name="lastname" value="<?php echo set_value('lastname', $card->lastname); ?>">
                            <?php echo form_error('lastname', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="middlename" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo set_value('middlename', $card->middlename); ?>">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control <?php echo form_error('mobile_number') ? 'is-invalid' : ''; ?>" id="mobile_number" name="mobile_number" value="<?php echo set_value('mobile_number', $card->mobile_number); ?>">
                            <?php echo form_error('mobile_number', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" class="form-control <?php echo form_error('job_title') ? 'is-invalid' : ''; ?>" id="job_title" name="job_title" value="<?php echo set_value('job_title', $card->job_title); ?>">
                            <?php echo form_error('job_title', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label d-block">Card Image</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?php echo form_error('card_image') ? 'is-invalid' : ''; ?>" id="customFile" name="card_image" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <?php echo form_error('card_image', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                        </div>
                    </div>

                    <?php if (is_current_user(['doctor'])): ?>
                        <hr class="border-secondary">

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="prc_number" class="form-label">PRC Number</label>
                                <input type="text" class="form-control <?php echo form_error('prc_number') ? 'is-invalid' : ''; ?>" id="prc_number" name="prc_number" value="<?php echo set_value('prc_number', $card->prc_number); ?>">
                                <?php echo form_error('prc_number', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="profession" class="form-label">Profession</label>
                                <input type="text" class="form-control <?php echo form_error('profession') ? 'is-invalid' : ''; ?>" id="profession" name="profession" value="<?php echo set_value('profession', $card->profession); ?>">
                                <?php echo form_error('profession', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="specialty" class="form-label">Specialty</label>
                                <input type="text" class="form-control <?php echo form_error('specialty') ? 'is-invalid' : ''; ?>" id="specialty" name="specialty" value="<?php echo set_value('specialty', $card->specialty); ?>">
                                <?php echo form_error('specialty', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="hospital_affiliation" class="form-label">Hospital Affiliation</label>
                                <input type="text" class="form-control <?php echo form_error('hospital_affiliation') ? 'is-invalid' : ''; ?>" id="hospital_affiliation" name="hospital_affiliation" value="<?php echo set_value('hospital_affiliation', $card->hospital_affiliation); ?>">
                                <?php echo form_error('hospital_affiliation', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right rounded-pill">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </div>


        </div>

        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header p-3">
                    <p class="h4 m-0">
                        <i class="fas fa-camera mr-2"></i> Profile Image
                    </p>
                </div>


                <div class="card-body">
                    <label class="form-label d-block">Card Image</label>

                    <div class="custom-file">
                        <input type="file" class="custom-file-input <?php echo form_error('card_image') ? 'is-invalid' : ''; ?>" id="customFile" name="card_image" accept="image/*">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        <?php echo form_error('card_image', '<div class="invalid-feedback">', '</div>'); ?>
                    </div>

                    <?php if (!empty($card->card_image)): ?>
                        <div class="mb-2">
                            <img id="cardImagePreview" src="<?php echo $card->card_image; ?>" alt="Card Image" class="img-thumbnail">
                        </div>
                    <?php else: ?>
                        <div class="mb-2">
                            <img id="cardImagePreview" src="" alt="Card Image" class="img-thumbnail d-none">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>


    <script>
        $(function() {
            $('#customFile').on('change', function(e) {
                let input = this;
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cardImagePreview').attr('src', e.target.result).removeClass('d-none');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        })
    </script>

<?php else: ?>

    <div class="card h-100 w-100">
        <div class="card-body">
            <h1 class="text-center m-0">No Active Card Found</h1>
        </div>
    </div>

<?php endif; ?>