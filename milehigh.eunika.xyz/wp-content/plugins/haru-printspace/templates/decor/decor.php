<?php
/** 
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( function_exists( 'haru_get_option' ) ) {
    $cl_primary = haru_get_option( 'haru_primary_color', '#2ebb77' );
} else {
    $cl_primary = '#2ebb77';
}
?>

<div class="haru-decor__content">
	<?php if ( in_array( $settings['pre_style'], array( 'style-1' ) ) ) : ?>
	<div class="haru-decor__circle haru-decor__circle--gradient" style="background: linear-gradient(to right, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : esc_attr( $cl_primary ); ?> 23.86%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : haru_hex2rgba( $cl_primary,  0.403383 ); ?> 93.86% );">
	</div>
	<?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-2" style="background: linear-gradient(339deg, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : 'rgba(242, 186, 154, 0.00)'; ?> 0%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : 'rgba(239, 148, 228, 0.60)'; ?> 60.89%, <?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#9F96F6'; ?> 100% );">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-3' ) ) ) : ?>
    <div class="haru-decor__ellipse haru-decor__ellipse--blur" style="background: <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : $cl_primary; ?>">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-4' ) ) ) : ?>
    <div class="haru-decor__ellipse haru-decor__dotted" style="background-image: radial-gradient(circle, <?php echo ( $settings['bg_color_1'] ) ? $settings['bg_color_1'] : $cl_primary; ?> <?php echo ( ! empty( $settings['dot_size']['size'] ) ) ? $settings['dot_size']['size'] . $settings['dot_size']['unit'] : '2px'; ?>, transparent 0)">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-5' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--layered" style="">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-6' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-6" style="background: linear-gradient(148deg, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#ffb36c'; ?> 2.17%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#fff3fc'; ?> 100% );">
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-7' ) ) ) :
        $decor_id = uniqid();
    ?>
    <svg width="1345" height="1120" viewBox="0 0 1345 1120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g opacity="0.4" filter="url(#filter0_f_<?php echo esc_attr( $decor_id ); ?>)">
            <path d="M1340.09 537.907C1340.09 770.174 1057.89 1115.22 825.621 1115.22C593.354 1115.22 4.53516 745.313 4.53516 513.046C4.53516 280.78 568.494 4.09746 800.761 4.09746C1033.03 4.09746 1340.09 305.64 1340.09 537.907Z" fill="url(#paint0_linear_<?php echo esc_attr( $decor_id ); ?>)"/>
        </g>
        <defs>
            <filter id="filter0_f_<?php echo esc_attr( $decor_id ); ?>" x="0.535156" y="0.0976562" width="1343.56" height="1119.12" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                <feGaussianBlur stdDeviation="2" result="effect1_foregroundBlur_<?php echo esc_attr( $decor_id ); ?>"/>
            </filter>
            <linearGradient id="paint0_linear_<?php echo esc_attr( $decor_id ); ?>" x1="372.151" y1="4.09766" x2="583.031" y2="1131.92" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#f2ba9a'; ?>"/>
                <stop offset="0.608863" stop-color="<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#ef94e4'; ?>"/>
                <stop offset="1" stop-color="<?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#9f96f7'; ?>"/>
            </linearGradient>
        </defs>
    </svg>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-8' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-8" style="background: linear-gradient(180deg, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#facade'; ?> 0%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#facade'; ?> 100% );">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-9' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--layered-gradient" style="">
        <div class="haru-decor__circle-1" style="background: linear-gradient(<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fff'; ?>, <?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#fff'; ?>) padding-box,
              linear-gradient(to bottom, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#d4e5ff'; ?>, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#fff'; ?> 100%) border-box;"></div>
        <div class="haru-decor__circle-2"></div>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-10' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__ellipse haru-decor__ellipse--gradient">
        <svg width="1089" height="897" viewBox="0 0 1089 897" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_f_<?php echo esc_attr( $decor_id ); ?>)">
                <path d="M1085 530.723C1085 782.018 709.727 893 458.638 893C207.548 893 4 689.285 4 437.99C4 186.695 492.932 4 744.022 4C995.111 4 1085 279.428 1085 530.723Z" fill="url(#paint0_linear_<?php echo esc_attr( $decor_id ); ?>)"/>
            </g>
            <defs>
                <filter id="filter0_f_<?php echo esc_attr( $decor_id ); ?>" x="0" y="0" width="1089" height="897" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                    <feGaussianBlur stdDeviation="2" result="effect1_foregroundBlur_<?php echo esc_attr( $decor_id ); ?>"/>
                </filter>
                <linearGradient id="paint0_linear_<?php echo esc_attr( $decor_id ); ?>" x1="1053.33" y1="-230.799" x2="436.487" y2="973.62" gradientUnits="userSpaceOnUse">
                    <stop offset="0.0174763" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#f7e2ff'; ?>" stop-opacity="0.65"/>
                    <stop offset="0.997356" stop-color="<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#f9f9f9'; ?>" stop-opacity="0"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-11' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__wave haru-decor__wave--gradient">
        <svg xmlns="http://www.w3.org/2000/svg" width="1918" height="984" viewBox="0 0 1918 984" fill="none">
            <path d="M0 57.0002C0 57.0002 262 -50 562.5 31.5C708.048 70.9748 1006.5 129.78 1325.5 75.1398C1644.5 20.5 1920 57.0002 1920 57.0002V984.001H0V57.0002Z" fill="url(#paint0_linear_<?php echo esc_attr( $decor_id ); ?>)"/>
            <defs>
                <linearGradient id="paint0_linear_<?php echo esc_attr( $decor_id ); ?>" x1="-531.064" y1="492.442" x2="2532.77" y2="492.442" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fbaa81'; ?>"/>
                    <stop offset="0.500986" stop-color="<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#e44bc5'; ?>"/>
                    <stop offset="1" stop-color="<?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#7370fb'; ?>"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-12' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__wave haru-decor__wave--gradient">
        <svg xmlns="http://www.w3.org/2000/svg" width="1918" height="960" viewBox="0 0 1918 960" fill="none">
            <path d="M0 33.0011C0 33.0011 310 114.424 555 51.1408C800 -12.1427 1063.5 -19.7194 1325.5 51.1408C1587.5 122.001 1920 33.0011 1920 33.0011V960.002H0V33.0011Z" fill="url(#paint0_linear_<?php echo esc_attr( $decor_id ); ?>)"/>
            <defs>
                <linearGradient id="paint0_linear_<?php echo esc_attr( $decor_id ); ?>" x1="-531.064" y1="480.399" x2="2532.77" y2="480.399" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fbaa81'; ?>"/>
                    <stop offset="0.500986" stop-color="<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#e44bc5'; ?>"/>
                    <stop offset="1" stop-color="<?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#7370fb'; ?>"/>
            </linearGradient>
            </defs>
        </svg>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-13' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__line haru-decor__line--horizontal">
        <svg xmlns="http://www.w3.org/2000/svg" width="508" height="79" viewBox="0 0 508 79" fill="none">
            <path d="M495.177 0.386551C493.958 0.779594 492.759 1.2379 491.581 1.73994C474.676 2.37664 457.703 2.42934 440.809 2.70003C432.233 2.84212 423.677 3.0064 415.121 3.21375C405.508 3.43128 395.857 3.5183 386.241 3.86502C367.222 4.5867 348.169 5.04867 329.143 6.02871C306.232 7.23249 283.322 8.43627 260.435 9.61919C241.473 10.6013 222.524 11.8639 203.558 12.9751C187.375 13.9361 171.212 14.9623 155.013 15.7503C131.544 16.8936 108.076 18.0368 84.6081 19.1801C75.7858 19.6163 66.9695 19.8586 58.1506 20.1871C53.1891 21.8212 48.613 24.2216 44.4639 27.4327C34.121 34.5024 24.5857 43.2998 16.0939 52.4745C11.286 57.4754 7.00386 62.8806 3.22603 68.6895C2.30496 70.6004 1.40541 72.512 0.484344 74.4229C-0.370091 77.6505 0.817404 78.9375 4.09053 78.2637C30.9132 77.2897 57.7453 76.0142 84.5558 74.7381C100.107 74.0161 115.638 73.2288 131.172 72.3554C155.099 71.0109 179.004 69.6657 202.931 68.2997C223.039 67.1594 243.159 66.3643 263.261 65.3963C282.264 64.5017 301.275 63.9953 320.289 63.4028C338.701 62.813 357.12 62.6546 375.521 62.3878C394.697 62.1236 413.885 62.2046 433.058 62.0481C437.926 62.0059 442.791 62.0929 447.596 61.3161C452.753 59.6234 457.484 57.1201 461.787 53.806C468.747 48.8507 475.334 43.4311 481.526 37.5467C487.781 31.7288 493.597 25.4878 498.973 18.8452C500.82 16.252 502.667 13.6587 504.514 11.0655C507.079 8.23599 507.931 5.09449 507.091 1.64162C504.646 0.5956 501.865 0.681306 499.243 0.513341C498.448 0.466989 497.652 0.420636 496.878 0.396485C496.339 0.401245 495.757 0.404665 495.177 0.386551Z" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#cbff77'; ?>"/>
        </svg>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-14' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__line haru-decor__line--horizontal">
        <svg xmlns="http://www.w3.org/2000/svg" width="508" height="120" viewBox="0 0 508 120" fill="none">
            <path d="M353.681 13.9543C339.511 16.0782 325.37 18.2298 311.199 20.3537C294.193 22.928 277.17 25.3777 260.193 28.3606C236.464 32.5504 212.74 36.7714 189.036 40.9577C180.191 42.5136 171.253 43.765 162.386 45.1652C149.864 47.1276 137.347 49.1212 124.825 51.0837C117.338 52.2639 109.677 52.5475 102.118 53.198C88.9385 54.3615 75.7849 55.5214 62.6057 56.6849C53.8125 57.4721 44.9811 57.7884 36.1496 58.2951C32.6081 60.4605 29.5018 63.3282 26.8221 66.8359C20.0188 74.7466 14.0729 84.159 9.0194 93.7988C6.1123 99.0831 3.66196 104.654 1.66837 110.512C1.24871 112.41 0.854673 114.305 0.430762 116.172C0.253779 119.275 1.35919 120.298 3.74699 119.242C17.8483 118.524 31.9027 117.654 45.9829 116.59C59.4139 115.551 72.8492 114.543 86.2803 113.504C91.4221 113.12 96.5171 112.393 101.642 111.693C103.128 111.491 104.589 111.291 106.075 111.088C119.968 109.225 133.831 107.333 147.723 105.469C166.741 102.906 185.665 99.8481 204.645 97.0045C215.257 95.3978 225.87 93.791 236.488 92.2154C242.317 91.3248 248.194 90.7769 254.049 90.0732C278.729 87.1183 303.41 84.1634 328.09 81.2085C329.734 81.0159 331.4 80.9791 333.082 80.8765C339.177 80.5845 345.275 80.3238 351.369 80.0318C362.028 79.5296 372.666 79.062 383.3 78.5633C397.071 78.8741 410.86 79.1192 424.645 79.714C424.551 80.1712 424.456 80.6284 424.337 81.0891C424.103 85.1199 425.563 86.4442 428.669 85.1001C438.978 84.1378 449.33 83.487 459.563 81.9639C464.309 79.0629 468.458 75.2277 472.069 70.5138C477.962 63.3937 483.369 55.7688 488.315 47.6354C493.35 39.5851 497.861 31.1302 501.842 22.2398C503.151 18.8239 504.46 15.408 505.768 11.9921C507.752 8.16676 507.977 4.26405 506.463 0.249347C499.357 -0.177614 492.247 0.697386 485.2 1.27798C480.144 1.71399 475.083 2.11884 470.027 2.55485C459.034 3.48343 447.995 4.25971 436.985 5.06365C414.731 6.67185 392.557 9.25294 370.376 11.5813C368.394 11.7882 366.417 12.0262 364.444 12.2954C360.865 12.8472 357.286 13.399 353.681 13.9543Z" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#cbff77'; ?>"/>
        </svg>
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-15' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-15" style="background: linear-gradient(143deg, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#4d58bb'; ?> 8.27%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : 'rgba(240, 73, 193, 0.58)'; ?> 94.69% );">
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-16' ) ) ) :
        $decor_id = uniqid();
    ?>
        <div class="haru-decor__shape haru-decor__shape--z">
            <svg width="616" height="478" viewBox="0 0 616 478" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M293.716 78.918C247.131 89.9567 200.568 101.458 154.027 113.391C148.631 114.774 143.281 116.127 137.97 117.469C102.171 126.519 68.2143 135.103 34.7235 149.541C21.1421 155.396 6.48081 145.831 1.97652 128.177C-2.52776 110.522 4.83066 91.4642 18.412 85.609C55.3069 69.7032 92.7986 60.2453 128.354 51.2758C133.615 49.9488 138.833 48.6325 144 47.3076C201.037 32.6835 258.122 18.7008 315.249 5.417C315.303 5.40015 315.361 5.38207 315.422 5.3627C316.05 5.16494 316.941 4.88803 318.005 4.5713C320.089 3.95092 323.011 3.12625 326.073 2.42846C328.842 1.7975 332.925 0.9832 336.906 0.892938C338.65 0.853402 342.337 0.868449 346.455 2.31625C349 3.21085 362.79 8.60725 366.081 28.9307C367.374 36.9173 366.395 43.7686 365.8 47.126C365.102 51.0721 364.095 54.6326 363.21 57.4073C361.435 62.9777 359.126 68.5433 357.136 73.0433C355.074 77.7066 352.949 82.1289 351.305 85.4995C351.031 86.062 350.23 87.6961 349.701 88.7773C349.443 89.3048 349.249 89.7007 349.212 89.7762C348.808 90.6039 348.605 91.0299 348.527 91.1944C348.48 91.292 348.478 91.2976 348.503 91.2404C328.128 137.524 304.95 175.338 282.388 211.504C251.465 261.073 221.555 312.695 195.745 370.851C195.027 372.47 194.278 374.129 193.51 375.831C190.433 382.647 187.049 390.141 184.109 398.422C183.346 400.571 182.673 402.617 182.092 404.548C182.835 404.585 183.615 404.61 184.435 404.623C187.927 404.679 191.507 404.525 195.712 404.345L195.913 404.336C199.949 404.163 204.738 403.959 209.436 404.113C255.264 405.62 301.176 405.289 347.531 404.898C348.979 404.886 350.427 404.873 351.876 404.861C396.681 404.481 441.911 404.098 487.182 405.372C502.428 405.801 517.686 406.834 532.485 407.835C534.765 407.989 537.033 408.143 539.289 408.293C556.382 409.433 572.916 410.412 589.298 410.412C603.607 410.412 615.206 425.49 615.206 444.09C615.206 462.69 603.607 477.768 589.298 477.768C571.469 477.768 553.773 476.704 536.634 475.561C534.315 475.407 532.007 475.251 529.711 475.096C514.855 474.091 500.458 473.118 486.06 472.713C441.533 471.459 396.95 471.837 351.939 472.218L347.868 472.253C301.604 472.643 254.898 472.985 208.126 471.448C205.18 471.351 201.884 471.473 197.621 471.656L197.009 471.683C193.123 471.85 188.494 472.049 183.799 471.975C174.09 471.82 161.366 470.541 148.984 463.259C137.389 456.439 129.352 442.191 127.98 424.037C126.424 403.448 132.438 383.219 137.061 370.199C141.203 358.532 146.23 347.435 149.291 340.681C149.9 339.336 150.431 338.164 150.862 337.193C178.654 274.57 210.506 219.79 242.141 169.079C260.698 139.334 278.062 110.957 293.716 78.918Z" fill="url(#paint0_linear_<?php echo esc_attr( $decor_id ); ?>)"/>
                <defs>
                    <linearGradient id="paint0_linear_<?php echo esc_attr( $decor_id ); ?>" x1="-169.331" y1="239.326" x2="811.34" y2="239.326" gradientUnits="userSpaceOnUse">
                        <stop offset="0" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fbaa81'; ?>"/>
                        <stop offset="0.500986" stop-color="<?php echo ( $settings['bg_color_1'] ) ? $settings['bg_color_1'] : '#e44bc5'; ?>"/>
                        <stop offset="1" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#7370fb'; ?>"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-17' ) ) ) :
        $decor_id = uniqid();
    ?>
        <div class="haru-decor__shape haru-decor__shape--star">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M60 30C33.7073 32.0487 32.0487 33.7073 30 60C27.9512 33.7073 26.2927 32.0487 0 30C26.2927 27.9512 27.9512 26.2927 30 0C32.0487 26.2927 33.7073 27.9512 60 30Z" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#0affd3'; ?>"/>
            </svg>
        </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-18' ) ) ) :
        $decor_id = uniqid();
    ?>
        <div class="haru-decor__grid haru-decor__grid--circle">
            <svg width="768" height="671" viewBox="0 0 768 671" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.4">
                    <mask id="mask0_<?php echo esc_attr( $decor_id ); ?>" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="768" height="671">
                        <rect x="96.1641" width="1.29949" height="670.538" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="240.406" width="1.29949" height="670.538" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="384.648" width="1.29949" height="670.538" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="528.891" width="1.29949" height="670.538" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="673.141" width="1.29949" height="670.538" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="768" y="109.158" width="1.29952" height="768" transform="rotate(90 768 109.158)" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="768" y="210.518" width="1.29952" height="768" transform="rotate(90 768 210.518)" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="768" y="311.879" width="1.29952" height="768" transform="rotate(90 768 311.879)" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                        <rect x="768" y="413.238" width="1.29952" height="768" transform="rotate(90 768 413.238)" fill="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#022c2e'; ?>"/>
                    </mask>
                    <g mask="url(#mask0_<?php echo esc_attr( $decor_id ); ?>)">
                        <circle cx="528.888" cy="158.538" r="239.107" fill="url(#paint0_radial_<?php echo esc_attr( $decor_id ); ?>)"/>
                        <circle cx="239.107" cy="391.148" r="239.107" fill="url(#paint1_radial_<?php echo esc_attr( $decor_id ); ?>)"/>
                    </g>
                </g>
                <defs>
                    <radialGradient id="paint0_radial_<?php echo esc_attr( $decor_id ); ?>" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(528.888 158.538) rotate(90) scale(239.107)">
                        <stop offset="0" stop-color="white" stop-opacity="0.51"/>
                        <stop offset="1" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <radialGradient id="paint1_radial_<?php echo esc_attr( $decor_id ); ?>" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(239.107 391.148) rotate(90) scale(239.107)">
                        <stop offset="0" stop-color="white" stop-opacity="0.51"/>
                        <stop offset="1" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                </defs>
            </svg>
        </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-19' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-19" style="background: linear-gradient(143deg, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#2e1736'; ?> 26.4%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#20316f'; ?> 59.53%, <?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#8229ac'; ?> 94.69%);">
    </div>
    <?php endif; ?>


    <?php
        if ( in_array( $settings['pre_style'], array( 'style-20' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__ellipse haru-decor__ellipse--gradient-20">
        <svg width="913" height="726" viewBox="0 0 913 726" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_f_<?php echo esc_attr( $decor_id ); ?>)">
                <ellipse cx="456.684" cy="363.419" rx="256.105" ry="162.481" fill="url(#paint0_linear_<?php echo esc_attr( $decor_id ); ?>)"/>
            </g>
            <defs>
            <filter id="filter0_f_<?php echo esc_attr( $decor_id ); ?>" x="0.578125" y="0.938538" width="912.211" height="724.962" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_<?php echo esc_attr( $decor_id ); ?>"/>
            </filter>
            <linearGradient id="paint0_linear_<?php echo esc_attr( $decor_id ); ?>" x1="854.257" y1="228.792" x2="369.439" y2="715.821" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fbaa81'; ?>"/>
                <stop offset="1" stop-color="<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#e44bc5'; ?>"/>
            </linearGradient>
            </defs>
        </svg>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-21' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__ellipse haru-decor__ellipse--double-21">
        <svg width="484" height="338" viewBox="0 0 484 338" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M449.991 264.59C445.445 274.466 435.362 281.305 420.874 285.152C406.39 288.998 387.577 289.83 365.712 287.747C321.988 283.583 266.177 267.776 208.654 241.297C151.131 214.819 102.828 182.701 71.2298 152.194C55.4291 136.938 43.8265 122.105 37.3287 108.601C30.8291 95.0937 29.4679 82.9867 34.014 73.1106C38.56 63.2345 48.6425 56.3952 63.1306 52.5483C77.6147 48.7026 96.428 47.8705 118.292 49.9528C162.016 54.1169 217.828 69.9243 275.351 96.4027C332.873 122.881 381.177 154.999 412.775 185.506C428.576 200.762 440.178 215.595 446.676 229.099C453.176 242.606 454.537 254.713 449.991 264.59Z" stroke="<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fff'; ?>"/>
            <path d="M403.193 235.031C401.807 243.661 395.476 251.151 385.054 257.282C374.635 263.411 360.193 268.142 342.739 271.269C307.834 277.523 260.996 277.348 210.506 269.244C160.016 261.14 115.476 246.648 84.2818 229.784C68.6827 221.352 56.4463 212.339 48.4692 203.257C40.4893 194.172 36.8204 185.077 38.2057 176.447C39.5909 167.817 45.9218 160.327 56.344 154.196C66.7627 148.066 81.2049 143.336 98.6595 140.209C133.564 133.955 180.402 134.13 230.892 142.234C281.382 150.338 325.923 164.83 357.116 181.693C372.715 190.126 384.952 199.139 392.929 208.221C400.909 217.306 404.578 226.4 403.193 235.031Z" stroke="<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_1'] : '#fff'; ?>"/>
        </svg>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-22' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-22">
        <div class="haru-decor__circle-22" style="background: linear-gradient(7deg, rgba(<?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : '#fbaa81'; ?>, 0.17) 6.12%, rgba(<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#e44bc5'; ?>, 0.49) 50.69%, <?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#7370fb'; ?> 95.08%);">
        </div>
    </div>
    <?php endif; ?>

    <?php
        if ( in_array( $settings['pre_style'], array( 'style-23' ) ) ) :
        $decor_id = uniqid();
    ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-23">
        <div class="haru-decor__circle-23" style="background: linear-gradient(7deg, rgba(<?php echo ( ! empty( $settings['bg_color_1'] )) ? $settings['bg_color_1'] : '#fbaa81'; ?>, 0) 6.12%, rgba(<?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : '#e44bc5'; ?>, 0.49) 50.69%, <?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : '#7370fb'; ?> 95.08%);">
        </div>
    </div>
    <?php endif; ?>
</div>
