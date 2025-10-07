// assets/js/photoswipe-gallery.js
const images = [
    "https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-embroidery-scaled.webp",
    "https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-dtf-2025-scaled.webp",
    "https://2kt.eunika.xyz/wp-content/uploads/2025/08/2k-screenprint-scaled.webp",
    "https://2kt.eunika.xyz/wp-content/uploads/2025/08/6_4a3163ec-ef29-457e-815c-7848a21f66a7-scaled.webp",
    "https://2kt.eunika.xyz/wp-content/uploads/2025/08/7_efb8f5a6-5eb5-4b12-90f0-d064849b5cfd-scaled.webp",
    "https://2kt.eunika.xyz/wp-content/uploads/2025/08/8_a39d853f-c751-458e-b18c-fb545b16ef5b-scaled.webp"
];

const alts = [
    "Embroidery design",
    "DTF 2025 design",
    "Screenprint design",
    "Design 6",
    "Design 7",
    "Design 8"
];

let currentIndex = 0;
let thumbRect = null;
const pswp = document.getElementById('pswp');
const pswpImg = document.getElementById('pswpImg');
const pswpCounter = document.getElementById('pswpCounter');

function openPhotoSwipe(index, thumbElement) {
    currentIndex = index;
    thumbRect = thumbElement.getBoundingClientRect();
    pswp.style.display = 'block';
    pswpImg.src = images[currentIndex];
    pswpImg.alt = alts[currentIndex];
    updateCounter();
    document.body.style.overflow = 'hidden';

    const fullRect = pswpImg.getBoundingClientRect();
    const scaleX = thumbRect.width / fullRect.width;
    const scaleY = thumbRect.height / fullRect.height;
    const translateX = thumbRect.left - fullRect.left;
    const translateY = thumbRect.top - fullRect.top;

    pswpImg.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scaleX}, ${scaleY})`;
    pswpImg.style.opacity = '0';

    requestAnimationFrame(() => {
        pswpImg.style.transition = 'transform 0.4s ease, opacity 0.4s ease';
        pswpImg.style.transform = 'translate(0, 0) scale(1, 1)';
        pswpImg.style.opacity = '1';
    });

    setTimeout(() => {
        pswpImg.style.transition = '';
    }, 400);
}

function closePhotoSwipe() {
    if (!thumbRect) {
        pswp.style.display = 'none';
        document.body.style.overflow = 'auto';
        return;
    }
    const fullRect = pswpImg.getBoundingClientRect();
    const scaleX = thumbRect.width / fullRect.width;
    const scaleY = thumbRect.height / fullRect.height;
    const translateX = thumbRect.left - fullRect.left;
    const translateY = thumbRect.top - fullRect.top;

    pswpImg.style.transition = 'transform 0.4s ease, opacity 0.4s ease';
    pswpImg.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scaleX}, ${scaleY})`;
    pswpImg.style.opacity = '0';

    setTimeout(() => {
        pswp.style.display = 'none';
        pswpImg.style.transition = '';
        pswpImg.style.transform = '';
        pswpImg.style.opacity = '';
        document.body.style.overflow = 'auto';
    }, 400);
}

function changeSlide(step) {
    currentIndex += step;
    if (currentIndex >= images.length) currentIndex = 0;
    if (currentIndex < 0) currentIndex = images.length - 1;
    pswpImg.src = images[currentIndex];
    pswpImg.alt = alts[currentIndex];
    updateCounter();
}

function updateCounter() {
    pswpCounter.textContent = `${currentIndex + 1} / ${images.length}`;
}

pswp.addEventListener('click', (e) => {
    if (!e.target.classList.contains('pswp__img') && !e.target.classList.contains('pswp__button')) {
        closePhotoSwipe();
    }
});

document.addEventListener('keydown', (e) => {
    if (pswp.style.display === 'block') {
        if (e.key === 'ArrowLeft') changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
        if (e.key === 'Escape') closePhotoSwipe();
    }
});
