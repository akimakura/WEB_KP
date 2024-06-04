/* ------------------ Анимация__шапки-background ------------------ */
const swiper = new Swiper(".background-slider",{
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
/* ------------------ /Анимация__шапки-background ------------------ */

/* ------------------ Скрытое меню ------------------ */
const menuBtn = document.querySelector('.menu__btn');
const menu = document.querySelector('.menu__list');

menuBtn.addEventListener('click', () => {
  menu.classList.toggle('menu__list--active');
});
/* ------------------ /Скрытое меню ------------------ */


/* ------------------ Анимация__скрола ------------------ */
// Сразу создаём переменные
let navbar = document.getElementById('navbar').classList
let active_class = "navbar_scrolled"

// Слушаем событие прокрутки
window.addEventListener('scroll', e => {
  if(scrollY > 450) navbar.add(active_class)
  else navbar.remove(active_class)
})
/* ------------------ /Анимация__скрола ------------------ */


/* ------------------ Swiper__Инструктора ------------------ */
const blogSwiper = new Swiper(".blog__slider",{
  loop: true,
  slidesPerView: 1,
  spaceBetween: 10,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    768: {
      slidesPerView: 2,
      spaceBetween: 40,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 70,
    },
  },
});
/* ------------------ /Swiper__Инструктора ------------------ */


/* ------------------------------------- POPUP ------------------------------------- */
// Функция для открытия модального окна
function openModal(modalId) {
  document.getElementById(modalId).classList.add("open");
}

// Функция для закрытия модального окна
function closeModal(modalId) {
  document.getElementById(modalId).classList.remove("open");
}

/* ------------- id-popup ------------- */
// Обработчики событий для кнопок открытия модальных окон
document.getElementById("open-popup-btn_ksen").addEventListener("click", function() {
  openModal("popup_ksen");
});
document.getElementById("open-popup-btn_fed").addEventListener("click", function() {
  openModal("popup_fed");
});
document.getElementById("open-popup-btn_alim").addEventListener("click", function() {
  openModal("popup_alim");
});
document.getElementById("open-popup-btn_lid").addEventListener("click", function() {
  openModal("popup_lid");
});


// Обработчики событий для кнопок закрытия модальных окон
document.getElementById("close-popup-btn_ksen").addEventListener("click", function() {
  closeModal("popup_ksen");
});
document.getElementById("close-popup-btn_fed").addEventListener("click", function() {
  closeModal("popup_fed");
});
document.getElementById("close-popup-btn_alim").addEventListener("click", function() {
  closeModal("popup_alim");
});
document.getElementById("close-popup-btn_lid").addEventListener("click", function() {
  closeModal("popup_lid");
});
/* ------------- /id-popup ------------- */

// Закрытие модального окна при клике вне его
document.querySelectorAll(".popup").forEach(function(popup) {
  popup.querySelector(".popup__box").addEventListener("click", function(event) {
    event._isClickWithInModal = true;
  });
  popup.addEventListener("click", function(event) {
    if (!event._isClickWithInModal) {
      closeModal(event.currentTarget.id);
    }
  });
});
/* ------------------------------------- /POPUP ------------------------------------- */

/* ------------------------------------- КАЛЕНДАРИК ------------------------------------- */
document.getElementById('davaToday').valueAsDate = new Date();
/* ------------------------------------- /КАЛЕНДАРИК ------------------------------------- */