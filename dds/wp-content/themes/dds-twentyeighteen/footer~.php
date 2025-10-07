<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DDS_2018
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
        <div class="site-quick-contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title">Message Us</h2>
                        <p>BGC Taguig Law Firm – Law Firms in the Philippines</p>
                        <p>Let us help you manage your legal and regulatory needs so you and your staff can focus your attention on where it matters most – your core business.</p>

                        <table class="site__contact">
                            <tbody style="vertical-align: top;">
                                <tr>
                                    <td><i class="fa fa-map-marker"></i></td>
                                    <td>
                                        604 The Infinity Tower<br/>
                                        26th St., BGC<br/>
                                        Taguig City 1634
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-phone"></i></td>
                                    <td><a href="tel:+6324785826">(632) 478-5826</a></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-envelope"></i></td>
                                    <td><a href="mailto:info@duranschulze.com">info@duranschulze.com</a></td>
                                </tr>
                            </tbody>
                        </table>

                        <ul class="social-links__list my-2">
                            <li class="social__item"><a target="_blank" href="http://duranschulze-rs3.dojo.forge99.com/" class="social-link"><i class="fa fa-facebook"></i><span class="sr-only">Facebook</span></a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h2 class="title">Message Us</h2>
                        <?php echo do_shortcode( '[contact-form-7 id="38" title="Contact form 1"]' ); ?>
                    </div>
                </div>
            </div>
        </div>

		<div class="site-info">
            <div class="container">
                <span>Copyright &copy; 2018.</span>
                <span>DDS Law.</span>
                <span>All Rights Reserved.</span>
                <a href="<?php echo site_url(); ?>/privacy-policy/" class="site-info__link">Privacy Policy</a>
                <span class="sep">|</span>
                <a href="<?php echo site_url(); ?>/disclaimer/" class="site-info__link">Disclaimer</a>
				<span class="sep">|</span>
                <a href="<?php echo site_url(); ?>/sitemap/" class="site-info__link">Sitemap</a>
            </div><!-- .container -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>