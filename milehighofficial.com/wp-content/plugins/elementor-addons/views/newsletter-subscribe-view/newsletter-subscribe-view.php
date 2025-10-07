<div class="ea-newsletter-subscribe">
  <div class="newsletter-inner">
    <div class="nl-left">
      <h2 class="newsletter-title"><?php echo esc_html( $settings['title'] ); ?></h2>
    </div>
    <div class="nl-right">
      <div class="nl-card">
          <form class="form-row">
              <input type="email" class="email-input" placeholder="<?php echo esc_attr( $settings['placeholder'] ); ?>">
              <button type="submit" class="btn"><?php echo esc_html( $settings['button_text'] ); ?></button>
          </form>
        <div class="meta"><?php echo esc_html( $settings['description'] ); ?></div>
        <div class="success">Thanks — you're subscribed!</div>
      </div>
    </div>
  </div>
</div>
