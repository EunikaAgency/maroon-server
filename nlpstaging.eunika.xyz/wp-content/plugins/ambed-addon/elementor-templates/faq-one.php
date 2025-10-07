<div class="faq-page__left">
	<div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion-<?php echo esc_attr(uniqid()); ?>">
		<?php
		$active_question = 1;
		foreach ($settings['faq_lists'] as $list) :
		?>
			<div class="accrodion <?php echo esc_attr(('yes' == $list['active_status'] ? 'active' : '')); ?>">
				<div class="accrodion-title">
					<h4><?php echo wp_kses($list['question'], 'ambed_allowed_tags'); ?></h4>
				</div>
				<div class="accrodion-content">
					<div class="inner">
						<p><?php echo wp_kses($list['answer'], 'ambed_allowed_tags'); ?></p>
					</div><!-- /.inner -->
				</div>
			</div>
		<?php $active_question++;
		endforeach; ?>
	</div>
</div>