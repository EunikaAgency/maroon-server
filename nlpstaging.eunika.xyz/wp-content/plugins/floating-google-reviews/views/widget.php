<?php 
if (!defined('ABSPATH')) exit; 
?>

<div class="floating-widget">
    <div id="ratingBadge" class="rating-summary d-flex" onclick="toggleFGR(true)">
        <img src="https://www.gstatic.com/images/branding/product/1x/googleg_32dp.png" alt="Google Logo">
        <div>
            <div><strong>Google Rating</strong></div>
            <div class="stars">5.0 ★★★★★</div>
            <small class="text-muted">Based on <?php echo count($reviews_data); ?> reviews</small>
        </div>
    </div>

    <div id="fullReviewCard" class="review-card d-none position-relative">
        <div class="card-body">
            <div class="review-card-header d-flex align-items-center mb-3">
                <span class="close-icon text-danger" onclick="toggleFGR(false)">&times;</span>
                <div class="review-avatar">NP</div>
                <div class="ml-3">
                    <h5 class="mb-0">Newline Painting</h5>
                    <small class="star-rating text-warning mb-2">★★★★★</small>
                    <small class="star-rating text-warning mb-2 fs-6">5.0</small>
                </div>
            </div>

            <?php foreach ($reviews_data as $review): ?>
            <div class="mb-4 d-flex pe-2">
                <img src="<?php echo esc_url($review['reviewerPhotoUrl']); ?>" class="rounded-circle mr-3" width="40"
                    height="40" alt="<?php echo esc_attr($review['name']); ?>">
                <div>
                    <p class="text-primary h6"><?php echo esc_html($review['name']); ?></p>
                    <small class="text-muted d-block"><?php echo esc_html($review['publishAt']); ?></small>
                    <div class="star-rating text-warning"><?php echo str_repeat('★', (int)$review['stars']); ?></div>
                    <p class="pe-2"><?php echo esc_html($review['text']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="mb-2 text-center">
                <a href="https://search.google.com/local/reviews?placeid=ChIJt3chYvI_1moRrTV7QW3pSiA" target="_blank"
                    class="btn btn-sm btn-outline-secondary">See all reviews</a>
                <a href="#review-popup" onclick="openPopup()" class="btn btn-sm btn-outline-danger">Write a review</a>
            </div>

            <!-- Footer inside the card-body -->
            <div class="fgr-footer text-center">
                <div class="powered-by-google text-muted small mt-2">
                    <span>powered by <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg"
                            alt="Google" style="height: 12px; vertical-align: middle;"></span>
                </div>
            </div>

        </div> <!-- /.card-body -->
    </div> <!-- /#fullReviewCard -->
</div> <!-- /.floating-widget -->

<style>
@media (max-width: 768px) {
    .floating-widget .review-card {
        width: 100% !important;
        height: 100% !important;
        max-height: 100dvh !important;
        margin: 0 !important;
        border-radius: 0 !important;
        overflow-y: auto;
    }

    .floating-widget .card-body {
        height: 100% !important;
        overflow: visible;
        padding: 0 !important;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("Script loaded correctly.");
});

function toggleFGR(expand) {
    let widget = document.querySelector('.floating-widget');
    let fullReviewCard = document.getElementById('fullReviewCard');
    let ratingBadge = document.getElementById('ratingBadge');

    if (expand) {
        widget.classList.add('open');
        ratingBadge.classList.add('d-none');
        fullReviewCard.classList.remove('d-none');

        // If on mobile, expand to full screen
        if (window.innerWidth <= 768) {
            widget.style.width = "100%";
            widget.style.height = "100%";
        }
    } else {
        widget.classList.remove('open');
        ratingBadge.classList.remove('d-none');
        fullReviewCard.classList.add('d-none');

        // Reset dimensions on mobile
        if (window.innerWidth <= 768) {
            widget.style.width = "";
            widget.style.height = "";
        }
    }
}
document.addEventListener("DOMContentLoaded", function() {
    const ratingBadge = document.getElementById("ratingBadge");
    const floatingWidget = document.querySelector(".floating-widget");

    function checkAndToggleClass() {
        if (ratingBadge.classList.contains("d-none")) {
            floatingWidget.classList.add("open");
        } else {
            floatingWidget.classList.remove("open");
        }
    }

    // MutationObserver to detect class changes
    const observer = new MutationObserver(checkAndToggleClass);
    observer.observe(ratingBadge, {
        attributes: true,
        attributeFilter: ["class"]
    });

    // Initial check
    checkAndToggleClass();
});


function openPopup() {
    const url = "https://search.google.com/local/writereview?placeid=ChIJt3chYvI_1moRrTV7QW3pSiA";
    const width = 800;
    const height = 600;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;

    window.open(url, "_blank",
        `width=${width}, height=${height}, top=${top}, left=${left}, scrollbars=yes, resizable=yes`);
}
</script>