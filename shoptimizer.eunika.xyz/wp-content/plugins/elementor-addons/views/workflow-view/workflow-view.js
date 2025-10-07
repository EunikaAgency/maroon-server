document.addEventListener('DOMContentLoaded', () => {
  const slider = document.querySelector('.workflow-slider-track');
  const prevButton = document.querySelector('.workflow-slider-prev');
  const nextButton = document.querySelector('.workflow-slider-next');
  const currentCounter = document.querySelector('.workflow-slider-current');
  const totalCounter = document.querySelector('.workflow-slider-total');

  if (!slider) return;

  const slides = slider.querySelectorAll('.workflow-slide');
  let currentIndex = 0;
  totalCounter.textContent = slides.length;

  function updateSlider() {
    currentCounter.textContent = currentIndex + 1;
    prevButton.disabled = currentIndex === 0;
    nextButton.disabled = currentIndex === slides.length - 1;
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  nextButton.addEventListener('click', () => {
    if (currentIndex < slides.length - 1) {
      currentIndex++;
      updateSlider();
    }
  });

  prevButton.addEventListener('click', () => {
    if (currentIndex > 0) {
      currentIndex--;
      updateSlider();
    }
  });

  window.addEventListener('resize', () => {
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
  });

  updateSlider();
});
