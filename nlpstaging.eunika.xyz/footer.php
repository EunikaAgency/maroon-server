<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bootstrap 5 Template</title>
        <!-- Bootstrap 5 CSS CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            p {
                word-wrap: break-word;
            }
            .footer-heading {
                position: relative;
                display: inline-block;
                font-size: 20px;
                font-weight: 700;
                color: #ffffff; /* or your theme's text color */
                line-height: 30px;
                margin-bottom: 32px;
            }
            .footer-heading::before {
                content: "";
                position: absolute;
                bottom: -9px;
                left: 0;
                width: 40px;
                height: 2px;
                background-color: #d51c0b; /* the gold/brown line */
            }
            .footer-heading::after {
                content: "";
                position: absolute;
                bottom: -9px;
                left: 45px;
                width: 4px;
                height: 2px;
                background-color: #ffffff; /* the white tick */
            }
            /* Replace with your actual font paths */
            @font-face {
                font-family: 'icomoon';
                src: url('/fonts/icomoon.eot?ver=1.0');
                src: url('/fonts/icomoon.eot?ver=1.0#iefix') format('embedded-opentype'),
                url('/fonts/icomoon.ttf?ver=1.0') format('truetype'),
                url('/fonts/icomoon.woff?ver=1.0') format('woff'),
                url('/fonts/icomoon.svg?ver=1.0#icomoon') format('svg');
                font-weight: normal;
                font-style: normal;
            }
            /* Add display: inline-block to make icons visible */
            [class^="icon-"], [class*=" icon-"] {
                font-family: 'icomoon' !important;
                /* speak: never; */
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                display: inline-block; /* This was missing */
            }
            .icon-phone-call:before { content: "\e900"; }
            .icon-message:before { content: "\e924"; }
            .icon-location:before { content: "\e901"; }
            .social-icon {
                position: relative;
                height: 100%;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                color: #ffffff;
                background-color: #161E27;
                border-radius: 50%;
                overflow: hidden;
                transition: all 500ms ease;
                z-index: 1;
            }
            .social-icon:hover {
                color: #a47c68; /* Your --ambed-base color */
            }
            .social-icon::after {
                position: absolute;
                content: "";
                top: 0;
                left: 0;
                right: 0;
                height: 100%;
                background-color: #ffffff;
                transition-delay: 0.1s;
                transition-timing-function: ease-in-out;
                transition-duration: 0.4s;
                transition-property: all;
                opacity: 1;
                transform-origin: top;
                transform-style: preserve-3d;
                transform: scaleY(0);
                z-index: -1;
            }
            .social-icon:hover::after {
                opacity: 1;
                transform: scaleY(1);
            }
            .social-icon svg path {
                transition: fill 300ms ease-in-out !important;
            }
            .social-icon:hover svg path {
                fill: rgb(213,28,11) !important;
            }
            /* For SVG icons */
            .social-icon:hover svg path {
                fill: rgb(213,28,11) !important;
            }
            /* For span icons (like icon-message) */
            .social-icon:hover span[class^="icon-"] {
                color: rgb(213,28,11) !important;
            }
            /* Transition for both */
            .social-icon svg path,
            .social-icon span[class^="icon-"] {
                transition: all 300ms ease-in-out !important;
            }
            /* Add arrow to mb-2 list items */
            li.mb-2 > a.text-white {
                position: relative;
                padding-left: 18px; /* Space for arrow */
                display: inline-block;
                transition: all 500ms ease;
            }
            li.mb-2 > a.text-white::before {
                content: "\f105"; /* FontAwesome arrow */
                font-family: "Font Awesome 5 Free";
                font-weight: 900;
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                font-size: 12px;
                color: currentColor;
                opacity: 0.7;
                transition: all 500ms ease;
            }
            li.mb-2 > a.text-white:hover {
                padding-left: 22px; /* Extra space on hover */
            }
            li.mb-2 > a.text-white:hover::before {
                opacity: 1;
                left: 3px; /* Slight movement on hover */
            }
            .footer-content-block {
                margin-bottom: 2rem; /* Adjust as needed */
            }
        </style>
    </head>
    <body>
        <!-- Footer -->
        <footer class="text-white position-relative bg-dark bg-cover bg-center py-5 px-lg-5 px-4" style="background-image: url('https://nlpstaging.eunika.xyz/wp-content/uploads/2025/02/Newline-Painting-Banner5.jpg');">

        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: #222F3E; opacity: 0.97; z-index: 0;"></div>
            <div class="py-5 position-relative" style="z-index: 1;">
                <div class="container-fluid px-lg-5 px-md-4 px-3">
                    <div class="row gy-4">
                        <!-- Logo + About + Socials -->
                        <div class="col-lg-3 col-md-12">
                            <a href="https://nlpstaging.eunika.xyz/">
                            <img src="https://nlpstaging.eunika.xyz/wp-content/uploads/2025/02/Newline-Painting-Logo-White.png" alt="Newline Painting" class="mb-3" width="144" loading="lazy">
                            </a>
                            <p class="opacity-75 text-wrap">Newline Painting simplifies the painting process with upfront pricing, premium finishes, and a team you can trust — from prep to clean-up.</p>
                            <div class="d-flex gap-3 mt-3">
                                <div class="social-icon d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px; background-color: #161E27;">
                                    <a href="https://www.facebook.com/NewlinePaintingAustralia/" 
                                        target="_blank" 
                                        class="text-white d-flex align-items-center justify-content-center position-relative" 
                                        aria-label="Facebook" 
                                        style="width: 100%; height: 100%;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 512 512" class="m-auto">
                                            <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="social-icon d-flex align-items-center justify-content-center rounded-circle p-2" style="width: 40px; height: 40px; background-color: #161E27;">
                                    <a href="https://www.instagram.com/newlinepainting_official/" target="_blank" class="text-white d-flex align-items-center justify-content-center" aria-label="Instagram" style="width: 100%; height: 100%;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 448 512" class="m-auto">
                                            <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Company + Areas We Cover -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h5 class="footer-heading fw-bold mb-3">Company</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/about-us/" class="text-white text-decoration-none">About Us</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/reviews/" class="text-white text-decoration-none">Reviews</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/contact/" class="text-white text-decoration-none">Contact</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/how-it-works/" class="text-white text-decoration-none">How It Works</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/faqs/" class="text-white text-decoration-none">FAQs</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/projects/" class="text-white text-decoration-none">Projects</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/about-us/team/" class="text-white text-decoration-none">Our Team</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/glossary/" class="text-white text-decoration-none">Glossary</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/quote/" class="text-white text-decoration-none">Paint Cost Calculator</a></li>
                                <li class="mb-2"><a href="/sitemap.xml" class="text-white text-decoration-none">Sitemap</a></li>
                            </ul>
                            <h5 class="footer-heading fw-bold mt-4 mb-3">Areas We Cover</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/melbourne/" class="text-white text-decoration-none">Melbourne</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/melbourne/south-melbourne/" class="text-white text-decoration-none">South Melbourne</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/melbourne/port-melbourne/" class="text-white text-decoration-none">Port Melbourne</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/melbourne/north-melbourne/" class="text-white text-decoration-none">North Melbourne</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/melbourne/abbotsford/" class="text-white text-decoration-none">Abbotsford</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/geelong/" class="text-white text-decoration-none">Geelong</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/melbourne/laverton/" class="text-white text-decoration-none">Laverton</a></li>
                            </ul>
                        </div>
                        <!-- Services + Resources -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <h5 class="footer-heading fw-bold mb-3">Services</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/interior-painting/" class="text-white text-decoration-none">Interior Painting</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/exterior-painting/" class="text-white text-decoration-none">Exterior Painting</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/bathroom-bathtub-painting/" class="text-white text-decoration-none">Bathroom & Bathtub Painting</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/fence-painting/" class="text-white text-decoration-none">Fence Painting</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/garage-floor-painting/" class="text-white text-decoration-none">Garage Floor Painting</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/apartment-painting/" class="text-white text-decoration-none">Apartment Painting</a></li>
                                <li class="mb-2"><a href="/services/" class="text-white text-decoration-none">See All Painting Services</a></li>
                            </ul>
                            <h5 class="footer-heading fw-bold mt-4 mb-3">Resources</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/blog/" class="text-white text-decoration-none">Blog</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/epoxy-floors-everything-you-need-to-know/" class="text-white text-decoration-none">Epoxy Floor Guide</a></li>
                                <li class="mb-2"><a href="/interior-wall-ideas/" class="text-white text-decoration-none">Ultimate Wall Colour Guide</a></li>
                                <li class="mb-2"><a href="/popular-bedroom-colour-combination-2018/" class="text-white text-decoration-none">Bedroom Colour Combination Guide</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/paint-primer-guide/" class="text-white text-decoration-none">Primer Guide</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/peeling-paint-guide/" class="text-white text-decoration-none">Peeling Paint Guide</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/paint-primer-guide/" class="text-white text-decoration-none">Paint Primer Guide</a></li>
                                <li class="mb-2"><a href="https://nlpstaging.eunika.xyz/real-estate-partnership-program/" class="text-white text-decoration-none">Property Manager Program</a></li>
                            </ul>
                        </div>
                        <!-- Contact + Partners -->
                        <div class="col-lg-3 col-md-12">
                            <h5 class="footer-heading fw-bold mb-3">Contact</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-start border-bottom border-white border-opacity-10 mb-3 pb-2">
                                    <div class="social-icon d-flex align-items-center justify-content-center rounded-circle bg-dark me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: #161E27 !important;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width='1em' height='1em'><path fill="currentColor" d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.98.98 0 0 0-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02c-.37-1.11-.56-2.3-.56-3.53c0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99C3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99"/></svg>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white">Call anytime</p>
                                        <a href="tel:1300044206" class="text-white text-decoration-none hover-underline">1300 044 206</a>
                                    </div>
                                </li>

                                <!-- tite -->
                                <li class="d-flex align-items-start border-bottom border-white border-opacity-10 mb-3 pb-2">
                                    <div class="social-icon d-flex align-items-center justify-content-center rounded-circle bg-dark me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: #161E27 !important;">
                                        <span class="text-white fs-5 icon-message"></span>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white">Send email</p>
                                        <a href="mailto:support@newlinepainting.com.au" class="text-white text-decoration-none hover-underline text-break">support@newlinepainting.com.au</a>
                                    </div>
                                </li>

                                <li class="d-flex align-items-start border-bottom border-white border-opacity-10 mb-3 pb-2">
                                    <div class="social-icon d-flex align-items-center justify-content-center rounded-circle bg-dark me-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: #161E27 !important;">
                                        <span class="text-white fs-5 icon-location" style="font-size: 1.4rem;"></span>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white">47 Claremont St, South Yarra</p>
                                        <p class="mb-0 text-white">Melbourne, VIC 3141, Australia</p>
                                    </div>
                                </li>
                            </ul>
                            <h5 class="footer-heading fw-bold mt-4 mb-3">Partners</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="https://www.calibrecleaning.com.au/" class="text-white text-decoration-none">Calibre Cleaning</a></li>
                                <li class="mb-2"><a href="https://neatbrite.com/" class="text-white text-decoration-none">NeatBrite</a></li>
                                <li class="mb-2"><a href="https://ourlocalagent.com.au/" class="text-white text-decoration-none">Our Local Agent</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="bg-dark text-white text-center py-4">
            <div class="container">
                <p class="mb-0 fs-6">
                Copyright &copy; 2025 All Rights Reserved. Newline Painting. House Painting Melbourne
                <a href="/termsandconditions/" class="text-white text-decoration-underline">Terms &amp; Conditions</a>. 
                <a href="/privacy-policy/" class="text-white text-decoration-underline">Privacy Policy</a>
                </p>
            </div>
        </div>
        <!-- Bootstrap 5 JS Bundle with Popper CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>