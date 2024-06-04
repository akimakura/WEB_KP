

/* ------------------------------------- POPUP ------------------------------------- */
// Функция для открытия модального окна
function openModal(modalId) {
  document.getElementById(modalId).classList.add("open");
}

// Функция для закрытия модального окна
function closeModal(modalId) {
  document.getElementById(modalId).classList.remove("open");
}

/* ------------- ID-POPUP ------------- */
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
/* ------------- /ID-POPUP ------------- */

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




// /* ------------------------ POPUP ------------------------ */
// // Открыть модальное окно
// document.getElementById("open-popup-btn_ksen").addEventListener("click", function() {
//   document.getElementById("popup_ksen").classList.add("open")
// })

// document.getElementById("open-popup-btn_fed").addEventListener("click", function() {
//   document.getElementById("popup_fed").classList.add("open")
// })


// // Закрыть модальное окно
// document.getElementById("close-popup-btn_ksen").addEventListener("click", function() {
//   document.getElementById("popup_ksen").classList.remove("open")
// })

// document.getElementById("close-popup-btn_fed").addEventListener("click", function() {
//   document.getElementById("popup_fed").classList.remove("open")
// })


// // Закрыть модальное окно при клике вне его
// document.querySelector("#popup_ksen .popup__box").addEventListener('click', event => {
//   event._isClickWithInModal = true;
// });
// document.getElementById("popup_ksen").addEventListener('click', event => {
//   if (event._isClickWithInModal) return;
//   event.currentTarget.classList.remove('open');
// });

// document.querySelector("#popup_fed .popup__box").addEventListener('click', event => {
//   event._isClickWithInModal = true;
// });
// document.getElementById("popup_fed").addEventListener('click', event => {
//   if (event._isClickWithInModal) return;
//   event.currentTarget.classList.remove('open');
// });
// /* ------------------------ /POPUP ------------------------ */









// // Сразу создаём переменные
// let navbar = document.getElementById('navbar').classList
// let active_class = "navbar_scrolled"

// /**
//  * Слушаем событие прокрутки
//  */
// window.addEventListener('scroll', e => {
//   if(scrollY > 500) navbar.add(active_class)
//   else navbar.remove(active_class)
// })


// const swiper = new Swiper(".background-slider",{
//   effect: "fade",
//   pagination: {
//       el: ".swiper-pagination",
//       dynamicBullets: true,
//   },
//   autoplay: {
//   delay: 3000,
//   disableOnInteraction: false,
// },
// });


// const swiper = new Swiper(".blog__swiper",{
//   loop: true,
//   slidesPerView: 1,
//   spaceBetween: 10,
//   navigation: {
//     nextEl: '.swiper-button-next',
//     prevEl: '.swiper-button-prev',
//   },
//   breakpoints: {
//     768: {
//       slidesPerView: 2,
//       spaceBetween: 50,
//     },
//     1024: {
//       slidesPerView: 3,
//       spaceBetween: 80,
//     },
//   },
//   // autoplay: {
//   //   delay: 3000,
//   //   disableOnInteraction: false,
//   // },
//   });


// const swiper = new Swiper(".blog__slider", {
//     loop: true,
//     slidesPerView: 1,
//     // spaceBetween: 10,
//     navigation: {
//       nextEl: '.swiper-button-next',
//       prevEl: '.swiper-button-prev',
//     },
//     breakpoints: {
//       768: {
//         slidesPerView: 2,
//         // spaceBetween: 40,
//       },
//       1024: {
//         slidesPerView: 3,
//         // spaceBetween: 70,
//       },
//     },
//     autoplay: {
//       delay: 3000,
//       disableOnInteraction: false,
//     },
//   });

