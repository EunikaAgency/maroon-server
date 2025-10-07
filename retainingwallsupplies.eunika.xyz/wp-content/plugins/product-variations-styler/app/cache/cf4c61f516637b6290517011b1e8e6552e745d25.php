<script>
    var variations_json = <?php echo $variations_json; ?>;
    var default_variation = <?php echo wp_json_encode($default_attributes); ?>;
</script>

<div class="custom-swatches mt-4">


    <?php $__currentLoopData = $grouped_variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $attribute_title = str_replace('attribute_', '', $attribute);
            $attribute_title = str_replace('pa_', '', $attribute_title);
        ?>

        <div id='<?php echo e($attribute); ?>-buttons' class='specs'>

            <h5 class='bg-light d-flex px-2'>

                <?php if(isset($title_icons[$attribute])): ?>
                    <img src="<?= $title_icons[$attribute] ?>" class="mr-1">
                <?php endif; ?>

                <?php echo e(ucwords($attribute_title)); ?>

            </h5>

            <div class="attribute-variation-<?php echo e($attribute_title); ?>">

            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php

                    $image_attachment_id = 0;
                    if( isset( $images[$value]['image']['url']) ){
                        $image_attachment_id = $images[$value]['image_id'];

                    }



                    $active = $default_attributes[$attribute] == $value ? 'default-value' : '';
                ?>

                <button 
                    image_attachment_id="<?php echo e($image_attachment_id); ?>" 
                    for='<?php echo e($attribute); ?>' 
                    data-target="<?php echo e($attribute_title); ?>" 
                    selector="select[name=<?php echo e($attribute); ?>] option[value='<?php echo e($value); ?>']"
                    class='btn m-0 <?php echo e($active); ?> attribute-button <?php echo e($attribute == 'attribute_pa_size' || $attribute == 'attribute_pa_length'  ? 'dimensions' : ''); ?>

                    <?php echo e($attribute); ?>-button'  data-attribute='<?php echo e($attribute); ?>' data-value='<?php echo e($value); ?>'>

                    <?php if(isset($images[$value])): ?>
                        <div style='background-image:url(<?php echo e($images[$value]['image']['url']); ?>)' class='variant-img'></div>
                        <span><?php echo e(ucwords( str_replace("-", " ", $value)  )); ?></span>
                    <?php else: ?>
                        <?php if($attribute == 'attribute_pa_size'): ?>

                            <div class="d-flex align-items-center">
                                <span id="attribute_button_checkbox" style="width: 20px; height: 20px"
                                    class="d-inline rounded mr-3"></span>
                                <span><?php echo $sizes_html[$value]; ?></span>
                            </div>

                        <?php elseif($attribute == 'attribute_pa_length'): ?>

                            <div class="d-flex align-items-center">
                                <span id="attribute_button_checkbox" style="width: 20px; height: 20px"
                                    class="d-inline rounded mr-3"></span>
                                <span><?php echo $lengths_html[$value]; ?></span>
                            </div>

                        <?php else: ?>
                            <span><?php echo e(ucwords($value)); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>




        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
