<?php if ( ! empty( $settings['catalogue_items'] ) ) : ?>
<div class="ea-catalogue">


  <div class="catalogue-grid">
    <?php foreach ( $settings['catalogue_items'] as $item ) :
      $link     = $item['catalogue_link']['url'] ?: '#';
      $target   = ! empty( $item['catalogue_link']['is_external'] ) ? ' target="_blank"' : '';
      $nofollow = ! empty( $item['catalogue_link']['nofollow'] ) ? ' rel="nofollow"' : '';
    ?>
      <a href="<?php echo esc_url( $link ); ?>" class="item-card"<?php echo $target . $nofollow; ?>>
        <div class="image-container">
          <img src="<?php echo esc_url( $item['catalogue_image']['url'] ); ?>" alt="" class="item-image" loading="lazy" decoding="async" width="400" height="300"/>
        </div>
        <div class="item-title">
          <span class="swap">
            <span class="main"><?php echo esc_html( $item['catalogue_title'] ); ?></span>
            <span class="alt"><?php echo esc_html( $item['catalogue_title'] ); ?></span>
          </span>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>
