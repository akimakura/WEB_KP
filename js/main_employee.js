const swiper = new Swiper('.swimswiper', {
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