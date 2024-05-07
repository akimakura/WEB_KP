const swiper = new Swiper(".background-slider", {
    effect: "fade",
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
    },
    autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
});

const blogSwiper = new Swiper(".blog__slider", {
  loop: true,
  slidesPerView: 1,
  // spaceBetween: 10,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    768: {
      slidesPerView: 2,
      // spaceBetween: 40,
    },
    1024: {
      slidesPerView: 3,
      // spaceBetween: 70,
    },
  },
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
});
