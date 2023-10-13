const carousels = {};
const AUTO_TIME = 3000;

function createCarousel(carouselWrapperId, ITEM_COUNT) {
  const carouselWrapper = document.getElementById(carouselWrapperId);
  const carouselContent = carouselWrapper.getElementsByClassName('carousel-content')[0];
  let currentSlide = 0;

  let timer = setInterval(nextSlide, AUTO_TIME);

  function resetInterval() {
    clearInterval(timer);

    timer = setInterval(nextSlide, AUTO_TIME);
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % ITEM_COUNT;

    renderCarousel();
  }

  function prevSlide() {
    currentSlide -= 1;

    if (currentSlide < 0) {
      currentSlide = ITEM_COUNT - 1;
    }

    renderCarousel();
  }

  function renderCarousel() {
    carouselContent.style.left = `-${currentSlide * 100}%`;

    resetInterval();
  }

  carousels[carouselWrapperId] = {
    prevSlide,
    nextSlide,
  };
}

createCarousel('visual-carousel', 5);
createCarousel('alram-carousel', 5);
createCarousel('information-carousel', 5);
