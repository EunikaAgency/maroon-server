<?php
  if( have_rows('flexible_content') ):
    while ( have_rows('flexible_content') ) : the_row();
?>

<?php if(get_row_layout() == "image_banner") : ?>
  <section class="section-image-banner" style="background-image: url(<?php the_sub_field('background-image') ?>);">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if(get_row_layout() == "accordion") : ?>
    <section class="<?php the_sub_field('classname'); ?>" style="margin-bottom: <?php the_sub_field('margin_bottom'); ?>px; margin-top: <?php the_sub_field('margin_top'); ?>px; padding-bottom: <?php the_sub_field('padding_bottom'); ?>px; padding-top: <?php the_sub_field('padding_top'); ?>px">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="accordion-header"><?php the_sub_field('accordion_header'); ?></h2>
            <div class="panel-group" id="accordion">
              <?php if( have_rows('accordion_repeater') ): ?>
                <?php while ( have_rows('accordion_repeater') ) : the_row(); ?>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#<?php the_sub_field('accordion_id') ?>">
                            <i class="fa fa-chevron-down pull-right"></i>
                            <?php the_sub_field('accordion_title'); ?>
                          </a>
                        </h3>
                      </div>
                      <div id="<?php the_sub_field('accordion_id') ?>" class="panel-collapse collapse in">
                        <div class="panel-body">
                          <?php the_sub_field('accordion_content'); ?>
                        </div>
                      </div>
                    </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php endif; ?>

<?php if(get_row_layout() == "profiles_partner") : ?>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="profile-header"><?php the_sub_field('section_header'); ?></h2>
        </div>
      </div>
      <?php if( have_rows('profiles_partner') ): ?>
        <?php while ( have_rows('profiles_partner') ) : the_row(); ?>
          <div class="row profile-container <?php the_sub_field('profile_classname'); ?>" style="margin-bottom: <?php the_sub_field('margin_bottom'); ?>px; margin-top: <?php the_sub_field('margin_top'); ?>px; padding-bottom: <?php the_sub_field('padding_bottom'); ?>px; padding-top: <?php the_sub_field('padding_top'); ?>px">
            <div class="col-lg-5 col-md-12 col-sm-12">
              <div class="partner-image">
                <img src="<?php the_sub_field('partner_picture'); ?>" alt="">
              </div>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12">
              <div class="partner-name-pos">
                <h3><?php the_sub_field('partner_name'); ?></h3>
                <h4><?php the_sub_field('partner_position'); ?></h4>
              </div>
              <div class="partner-background">
                <?php the_sub_field('partner_background'); ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>

<?php if(get_row_layout() == "profiles_team") : ?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="profile-header"><?php the_sub_field('section_header'); ?></h2>
      </div>
    </div>
    <?php if( have_rows('team_profile') ): ?>
      <?php while ( have_rows('team_profile') ) : the_row(); ?>
        <div class="row profile-container <?php the_sub_field('profile_team_classname'); ?>" style="margin-bottom: <?php the_sub_field('margin_bottom'); ?>px; margin-top: <?php the_sub_field('margin_top'); ?>px; padding-bottom: <?php the_sub_field('padding_bottom'); ?>px; padding-top: <?php the_sub_field('padding_top'); ?>px">
          <div class="col-lg-7 col-md-12 col-sm-12">
            <div class="team-image">
              <img src="<?php the_sub_field('team_picture'); ?>" alt="">
            </div>
          </div>
          <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="partner-name-pos">
              <h3><?php the_sub_field('team_name'); ?></h3>
            </div>
            <div class="partner-background">
              <?php the_sub_field('team_description'); ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if(get_row_layout() == "areas_of_practice") : ?>
  <section class="<?php the_sub_field('classname'); ?>" style="background-color: <?php the_sub_field('background_color'); ?>; margin-bottom: <?php the_sub_field('margin_bottom'); ?>px; margin-top: <?php the_sub_field('margin_top'); ?>px; padding-bottom: <?php the_sub_field('padding_bottom'); ?>px; padding-top: <?php the_sub_field('padding_top'); ?>px">
    <div class="container">
      <div class="row mb-2">
        <div class="col-lg-12 text-center">
          <h2><?php the_sub_field('section_header'); ?></h2>
          <p><?php the_sub_field('section_subheader'); ?></p>
        </div>
      </div>
      <div class="row">
        <?php if( have_rows('practices') ): ?>
          <?php while ( have_rows('practices') ) : the_row(); ?>
            <div class="col-lg-3">
              <div class="practice-card text-center">
                <img src="<?php the_sub_field('practices_image'); ?>" alt="">
                <h5><?php the_sub_field('practices_title'); ?></h5>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
      <div class="row mt-2">
        <div class="col-lg-12">
          <?php the_sub_field('section_description'); ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
  if(get_row_layout() == "text"):
  $v = get_sub_field_object('column');
  $z = get_sub_field_object('layout');
  $u = get_sub_field_object('adjust_width');
  $y = get_sub_field_object('add_header');
  $bg = get_sub_field('background_image');
  $img = 'background-image: url(' . $bg . ');';
  $ht = '<div class="col-lg-12"><h2>' . get_sub_field('header_text') . '</h2></div>';
  $mw = '<div style="max-width: ' . get_sub_field('max_width') . 'px; margin: 0 auto">';
  $ov = get_sub_field('class_name');
?>
<!-- TEXT CONTENT -->
  <div class="<?php echo $z['value'] . ' ' . $ov; ?> text-content" style="background-color: <?php the_sub_field('background_color'); ?>; <?php echo (!$bg ? '' : $img ); ?> margin-bottom: <?php the_sub_field('margin_bottom'); ?>px; margin-top: <?php the_sub_field('margin_top'); ?>px; padding-bottom: <?php the_sub_field('padding_bottom'); ?>px; padding-top: <?php the_sub_field('padding_top'); ?>px">
    <?php echo ($ov == 'overlayed' ? '<div class="overlay"></div>' : ''); ?>
    <?php if ($v['value'] == '1_column'): ?>
    <div class="row">
      <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
      <div class="col-lg-12">
        <?php echo ($u['value'] == 'yes' ? $mw : '' ); ?>
        <?php the_sub_field('content01'); ?>
        <?php echo ($u['value'] == 'yes' ? '</div>' : '' ); ?>
      </div>
      <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>
    </div>

    <?php elseif ($v['value'] == '2_column'): ?>
    <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
        <div class="row">
        <?php echo ($y['value'] == 'yes' ? $ht : '' ); ?>

        <div class="col-lg-6 <?php echo ($ov == 'reorder' ? 'order-lg-1 order-2' : ''); ?>">
            <?php the_sub_field('content01'); ?>
        </div>
        <div class="col-lg-6 <?php echo ($ov == 'reorder' ? 'order-lg-2 order-1' : ''); ?>">
            <?php the_sub_field('content02'); ?>
        </div>
        </div>
    <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>

  <?php elseif ($v['value'] == '2b_column'): ?>
  <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
      <div class="row">
      <?php echo ($y['value'] == 'yes' ? $ht : '' ); ?>

      <div class="col-lg-8 order-lg-1 order-2">
          <?php the_sub_field('content01'); ?>
      </div>
      <div class="col-lg-4 order-lg-2 order-1">
          <?php the_sub_field('content02'); ?>
      </div>
      </div>
  <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>

  <?php elseif ($v['value'] == '2c_column'): ?>
  <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
      <div class="row">
      <?php echo ($y['value'] == 'yes' ? $ht : '' ); ?>

      <div class="col-lg-4">
          <?php the_sub_field('content01'); ?>
      </div>
      <div class="col-lg-8">
          <?php the_sub_field('content02'); ?>
      </div>
      </div>
  <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>

  <?php elseif ($v['value'] == '2a_column'): ?>
  <div class="row">
    <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
    <?php echo ($y['value'] == 'yes' ? $ht : '' ); ?>

    <div class="col-lg-3">
      <?php the_sub_field('content01'); ?>
    </div>
    <div class="col-lg-9">
      <?php the_sub_field('content02'); ?>
    </div>
    <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>
  </div>

    <?php elseif ($v['value'] == '2b_column'): ?>
    <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
        <div class="row">
        <div class="col-lg-9">
            <?php the_sub_field('content01'); ?>
        </div>
        <div class="col-lg-3">
            <?php the_sub_field('content02'); ?>
        </div>
        </div>
    <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>

    <?php elseif ($v['value'] == '3_column'): ?>
    <div class="row">
      <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
      <?php echo ($y['value'] == 'yes' ? $ht : '' ); ?>
      <div class="col-lg-4">
        <?php the_sub_field('content01'); ?>
      </div>
      <div class="col-lg-4">
        <?php the_sub_field('content02'); ?>
      </div>
      <div class="col-lg-4">
        <?php the_sub_field('content03'); ?>
      </div>
      <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>
    </div>


    <?php
      elseif ($v['value'] == 'flex_column'):
    ?>
      <?php
        if ($y['value'] == 'yes') {
      ?>
      <div class="row">
        <?php echo $ht; ?>
      </div>
      <?php
        }

        if( have_rows('flexible_section') ):
          while ( have_rows('flexible_section') ) : the_row();
          $subv = get_sub_field_object('columns');
    ?>

        <?php if ($subv['value'] == '1_column'): ?>
        <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width container">' : '' ); ?>
            <div class="row">
            <div class="col-lg-12">
                <?php echo ($u['value'] == 'yes' ? $mw : '' ); ?>
                <?php the_sub_field('n_content_1'); ?>
                <?php echo ($u['value'] == 'yes' ? '</div>' : '' ); ?>
            </div>
            </div>
        <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>

        <?php elseif ($subv['value'] == '2_column'): ?>
        <div class="row">
          <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>

          <div class="col-lg-6">
            <?php the_sub_field('n_content_1'); ?>
          </div>
          <div class="col-lg-6">
            <?php the_sub_field('n_content_2'); ?>
          </div>
          <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>
        </div>

        <?php elseif ($subv['value'] == '3_column'): ?>
        <div class="row">
          <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width">' : '' ); ?>
          <div class="col-lg-4">
            <?php the_sub_field('n_content_1'); ?>
          </div>
          <div class="col-lg-4">
            <?php the_sub_field('n_content_2'); ?>
          </div>
          <div class="col-lg-4">
            <?php the_sub_field('n_content_3'); ?>
          </div>
          <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>
        </div>

        <?php elseif ($subv['value'] == '4_column'): ?>
        <?php echo ($z['value'] == 'container-fluid' ? '<div class="custom-width container">' : '' ); ?>
            <div class="row">
            <div class="col-lg-3 col-sm-12">
                <?php the_sub_field('n_content_1'); ?>
            </div>
            <div class="col-lg-3 col-sm-12">
                <?php the_sub_field('n_content_2'); ?>
            </div>
            <div class="col-lg-3 col-sm-12">
                <?php the_sub_field('n_content_3'); ?>
            </div>
            <div class="col-lg-3 col-sm-12">
                <?php the_sub_field('n_content_4'); ?>
            </div>
            </div>
        <?php echo ($z['value'] == 'container-fluid' ? '</div>' : '' ); ?>

      <?php endif; ?>

      <?php if(get_row_layout() == "spacer"): ?>
        <div class="row">
          <div class="col-lg-12">
            <div style="height: <?php the_sub_field('spacer'); ?>px"></div>
          </div>
        </div>
      <?php endif; ?>

      <?php
        endwhile;
        endif;
      ?>

    <?php endif; ?>
  </div>
<!-- TEXT CONTENT #END -->
<?php endif; ?>

<?php
    endwhile;
  endif;
?>
