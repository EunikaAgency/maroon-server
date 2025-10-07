document.addEventListener('DOMContentLoaded', () => {
  const slider = document.querySelector('.ea-wft-slider-track');
  const prevButton = document.querySelector('.ea-wft-slider-prev');
  const nextButton = document.querySelector('.ea-wft-slider-next');
  const currentCounter = document.querySelector('.ea-wft-slider-current');
  const totalCounter = document.querySelector('.ea-wft-slider-total');

  if (!slider) return;

  const slides = slider.querySelectorAll('.ea-wft-slide');
  let currentIndex = 0;
  totalCounter.textContent = slides.length;

  function updateSlider() {
    const isDesktop = window.innerWidth >= 992;

    if (isDesktop) {
      currentCounter.textContent = '-';
      prevButton.disabled = true;
      nextButton.disabled = true;
      slider.style.transform = 'none';
    } else {
      currentCounter.textContent = currentIndex + 1;
      prevButton.disabled = currentIndex === 0;
      nextButton.disabled = currentIndex === slides.length - 1;
      slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
  }

  nextButton.addEventListener('click', () => {
    if (window.innerWidth < 992 && currentIndex < slides.length - 1) {
      currentIndex++;
      updateSlider();
    }
  });

  prevButton.addEventListener('click', () => {
    if (window.innerWidth < 992 && currentIndex > 0) {
      currentIndex--;
      updateSlider();
    }
  });

  window.addEventListener('resize', updateSlider);

  updateSlider();
});
