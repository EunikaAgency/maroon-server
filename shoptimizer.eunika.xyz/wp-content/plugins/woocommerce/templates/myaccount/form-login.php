<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="account-container">

	<?php if ( ! isset( $_GET['action'] ) || $_GET['action'] !== 'register' ) : ?>
		<div class="login-container">
			<div class="page-title">
				<h2 class="login-title"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
			</div>

			<form class="login-form woocommerce-form woocommerce-form-login login" method="post">
				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<p class="woocommerce-form-row form-row">
					<input type="text" placeholder="EMAIL" class="woocommerce-Input input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
				</p>

				<p class="woocommerce-form-row form-row">
					<input type="password" placeholder="PASSWORD" class="woocommerce-Input input-text" name="password" id="password" autocomplete="current-password" required />
				</p>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="forgot-link"><?php esc_html_e( 'Forgot your password?', 'woocommerce' ); ?></a>

				<div class="button-group">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<button type="submit" class="btn btn-black" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Sign In', 'woocommerce' ); ?></button>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>?action=register" class="btn btn-outline"><?php esc_html_e( 'Create Account', 'woocommerce' ); ?></a>
				</div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</form>
		</div>
	<?php endif; ?>


	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
		<?php if ( isset( $_GET['action'] ) && 'register' === $_GET['action'] ) : ?>
			<div class="register-container">
				<div class="page-title">
					<h2 class="login-title"><?php esc_html_e( 'Create account', 'woocommerce' ); ?></h2>
				</div>
				<form method="post" class="register-form woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<div class="name-row">
						<p class="woocommerce-form-row form-row half-width">
							<input type="text" placeholder="FIRST NAME" class="woocommerce-Input input-text" name="first_name" id="reg_first_name" autocomplete="given-name" value="<?php echo ( ! empty( $_POST['first_name'] ) ) ? esc_attr( wp_unslash( $_POST['first_name'] ) ) : ''; ?>" required />
						</p>

						<p class="woocommerce-form-row form-row half-width">
							<input type="text" placeholder="LAST NAME" class="woocommerce-Input input-text" name="last_name" id="reg_last_name" autocomplete="family-name" value="<?php echo ( ! empty( $_POST['last_name'] ) ) ? esc_attr( wp_unslash( $_POST['last_name'] ) ) : ''; ?>" required />
						</p>
					</div>

					<p class="woocommerce-form-row form-row">
						<input type="email" placeholder="EMAIL" class="woocommerce-Input input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<p class="woocommerce-form-row form-row">
							<input type="password" placeholder="PASSWORD" class="woocommerce-Input input-text" name="password" id="reg_password" autocomplete="new-password" required />
						</p>
					<?php else : ?>
						<p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>
					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<div class="button-group">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" class="btn btn-black createbtn" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'CREATE', 'woocommerce' ); ?></button>
					</div>

					<?php do_action( 'woocommerce_register_form_end' ); ?>
				</form>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


<style>
	.account-container {
		max-width: 425px;
		margin: 80px auto;
		display: flex;
		gap: 40px;
		justify-content: center;
		color: #211c1c !important;
	}
	.login-container, .register-container {
		flex: 1;
		text-align: center;
	}
	.page-title {
        /* padding-bottom: 2rem; */
		margin-bottom: 2rem;
		/* border-bottom: .2rem solid #211c1c; */
    }
	.login-title {
		font-size: 50px !important;
		font-weight: 400;
		position: relative;
		margin-bottom: 2rem;
		border-bottom: .2rem solid #211c1c;
		padding-bottom: 2rem;
	}
	
	.woocommerce-form {
		display: flex;
		flex-direction: column;
	}
	.woocommerce-form input {
		height: 55px;
		padding: 0 20px;
		font-size: 9px;
		border: none;
		border-radius: 0;
		background: #f4f4f4;
		outline: none;
	}
	.woocommerce-form input::placeholder {
		color: #3d3d3d !important;
		font-weight: 600 !important;
	}
	.woocommerce-form input:focus::placeholder {
		color: grey !important;
	}

	.forgot-link {
		text-align: left;
		font-size: 10px;
		color: #333;
		margin-bottom: 10px;
		display: inline-block;
		text-decoration: underline !important;
	}
	.button-group {
		display: flex;
		gap: 15px;
		margin-top: 1.6rem;
	}
	.btn {
		flex: 1;
		height: 40px;
		font-size: 10px;
		font-weight: bold;
		text-transform: uppercase;
		cursor: pointer;
		border: none;
		transition: 0.2s ease;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		text-decoration: none;
		letter-spacing: .125em;
	}
	.btn-black {
		background: #000;
		color: #fff;
	}
	.btn-black:hover {
		background: #333;
	}
	.btn-outline {
		background: #fff;
		border: 1px solid #cccccc;
		color: #000;
	}
	.btn-outline:hover {
		background: #000;
		color: #fff;
	}

	.site-content {
		padding-top: 0px !important;
	}
	.breadcrumbs {
		margin-top: 4rem !important;
	}

	/* Flex row for first and last name */
	.name-row {
		display: flex;
		gap: 20px;
		width: 100%;
	}
	.half-width {
		flex: 1;
	}

	.createbtn {
		flex: 0 0 auto !important;
		width: 9rem !important;
		margin: 0 auto; 
	}

</style>

<script>
	jQuery(document).ready(function ($) {
		<?php if ( isset($_GET['action']) && $_GET['action'] === 'register' ) : ?>
			$('.woocommerce-privacy-policy-text').remove();
			$('nav.breadcrumbs span').last().text('Create Account');
		<?php endif; ?>
	});
</script>