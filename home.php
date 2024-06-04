<?php
    include("path.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>КапитанПупс</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">   
    <link rel="stylesheet" href="css/home_style.css">
</head>
<body>

    <div class="wrapper">

        <header id="navbar" class="navbar header">
            <div class="container">
                <div class="header__inner">
                    <a href="<?php echo BASE_URL ?>" class="logo">
                        <img src="images/logo-4.png" style="width: 70px"
                         alt="" class="logo__img">
                    </a>
                    <nav class="menu">
                        <button class="menu__btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <ul class="menu__list">
                            <li class="mennu__list-item">
                                <a href="#hom" class="menu__list-link">Главная</a>
                            </li>
                            <li class="mennu__list-item">
                                <a href="#inf" class="menu__list-link">О нас</a>
                            </li>
                            <li class="mennu__list-item">
                                <a href="#serv" class="menu__list-link">Услуги</a>
                            </li>
                            <li class="mennu__list-item">
                                <a href="#blog" class="menu__list-link">Инструктора</a>
                            </li>
                            <li class="mennu__list-item">
                                <a href="#map" class="menu__list-link">Контакты</a>
                            </li>
                                <a href="Login.php" class="office__link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path d="M12 2A10.13 10.13 0 0 0 2 12a10 10 0 0 0 4 7.92V20h.1a9.7 9.7 0 0 0 11.8 0h.1v-.08A10 10 0 0 0 22 12 10.13 10.13 0 0 0 12 2zM8.07 18.93A3 3 0 0 1 11 16.57h2a3 3 0 0 1 2.93 2.36 7.75 7.75 0 0 1-7.86 0zm9.54-1.29A5 5 0 0 0 13 14.57h-2a5 5 0 0 0-4.61 3.07A8 8 0 0 1 4 12a8.1 8.1 0 0 1 8-8 8.1 8.1 0 0 1 8 8 8 8 0 0 1-2.39 5.64z"></path><path d="M12 6a3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2z"></path>
                                </svg>
                                </a>
                            <li>

                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="main">
            <section id="hom" class="top">
                <div class="container">
                    <h1 class="title">
                        Запишись на первое занятие!
                    </h1>
                    <a href="Register.php" class="top__link">Записаться</a>
                </div>
            </section>
            <div class="slider">
                <div class="swiper background-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide background__img" style="background-image: url(images/room-toor_1_pups.jpg);"></div>
                        <div class="swiper-slide background__img" style="background-image: url(images/plav_fon_bb.jpg);"></div>
                        <div class="swiper-slide background__img" style="background-image: url(images/room-toor_3.jpg);"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <section id="inf" class="water-features">
                <div class="container">
                    <h2 class="section-title">
                        Особенности воды  в КП
                    </h2>
                    <ul class="water-features__list">
                        <li class="water-features__item">
                            <img class="water-features__item-img" src="images/him.png" alt="">
                            <h3 class="water-features__item-title">
                                Идеальная вода
                            </h3>
                            <p class="water-features__item-text"> Качество воды в бассейне - ключевой элемент безопасности и удовольствия. Регулярная проверка и обработка воды обеспечивают чистоту, прозрачность и комфорт для плавающих.  </p>
                        </li>
                        <li class="water-features__item">
                            <img class="water-features__item-img" src="images/water.png" alt="">
                            <h3 class="water-features__item-title">
                                Глубокий бассейн
                            </h3>
                            <p class="water-features__item-text"> Глубина бассейна играет важную роль для безопасности и разнообразия активностей. Она обеспечивает место для плавания, прыжков и занятий водными видами спорта, удовлетворяя различные потребности пользователей.  </p>
                        </li>
                        <li class="water-features__item">
                            <img class="water-features__item-img" src="images/shower.png" alt="">
                            <h3 class="water-features__item-title">
                                Комфортный душ
                            </h3>
                            <p class="water-features__item-text"> Комфортные душевые - важная часть любого удобства. Современные системы обеспечивают регулировку температуры, мощности струи и функции массажа, создавая приятное и расслабляющее душевое пространство.  </p>
                        </li>
                        <li class="water-features__item">
                            <img class="water-features__item-img" src="images/temp.png" alt="">
                            <h3 class="water-features__item-title">
                                Всегда теплая вода
                            </h3>
                            <p class="water-features__item-text"> Температура детского бассейна имеет важное значение для комфорта и безопасности маленьких пловцов. Поддержание умеренной и приятной температуры создает идеальные условия для детского плавания.  </p>
                        </li>
                    </ul>
                </div>
            </section>

            <!------------------ lIST-Serv -------------------->
            <!-- <section id="serv" class="list-serv">
                <div class="container">
                    <div class="list-serv__inner">
                        <h2 class="section-title">
                            Перечень услуг
                        </h2>
                        <p class="list-serv__text"> "Наш бассейн предлагает разнообразные и качественные услуги для всех посетителей. Вас ждут занятия по аквагимнастике, индивидуальные уроки плавания с опытными инструкторами, а также расслабляющие сеансы гидромассажа. Проведите время в нашем бассейне с пользой и удовольствием!"  </p>
                        <ol class="list__serv-list">
                            <li class="list__serv-item text__up">Персональная тренировка</li>
                            <li class="list__serv-item text__up">Групповая тренировка</li>
                            <li class="list__serv-item text__up">Сплит-тренировка</li>
                            <li class="list__serv-item text__up">Детский массаж</li>
                        </ol>
                    </div>
                </div>
            </section> -->
            <!------------------ /lIST-Serv -------------------->

            <!----------------------- BLOG ------------------------->
            <section id="blog" class="blog">
                <div class="container">
                    <h3 class="section-title blog__title">
                        Тренерский состав
                    </h3>
                        <!-------------- Slider ---------------->
                        <div class="swiper blog__slider">
                            <div class="swiper-wrapper">
                                <!-------------- Content__block ---------------->
                                <button id="open-popup-btn_ksen" class="swiper-slide blog__button">
                                    <div class="swiper-slide blog__item">
                                        <img class="blog__item-img" src="images/inst-ksen-2.jpg" alt="">
                                        <h4 class="blog__item-title text__up">
                                            КСЕНИЯ
                                        </h4>
                                        <p class="blog__item-text text__low">
                                        Опытный тренер по плаванию с фокусом на технике и выносливости, вдохновляющий и мотивирующий своих подопечных к достижению успеха.
                                        </p>
                                    </div>
                                </button>
                                <!-------------- Content__block ---------------->
                                <button id="open-popup-btn_fed" class="swiper-slide blog__button">
                                    <div class="swiper-slide blog__item">
                                        <img class="blog__item-img" src="images/inst-fed-2.jpg" alt="">
                                        <h4 class="blog__item-title text__up">
                                            ФЕДОР
                                        </h4>
                                        <p class="blog__item-text text__low">
                                        Строгий и целеустремлённый тренер по плаванию, сосредотачивающий внимание на дисциплине, технике и стратегии соревнований.
                                        </p>
                                    </div>
                                </button>
                                <!-------------- Content__block ---------------->
                                <button id="open-popup-btn_alim" class="swiper-slide blog__button">
                                    <div class="swiper-slide blog__item">
                                        <img class="blog__item-img" src="images/inst-alim-2.jpg" alt="">
                                        <h4 class="blog__item-title text__up">
                                            АЛИМА
                                        </h4>
                                        <p class="blog__item-text text__low">
                                        Внимательный и заботливый тренер по плаванию, создающий поддерживающую среду и помогающий спортсменам развивать свои навыки и потенциал.
                                        </p>
                                    </div>
                                </button>
                                <!-------------- Content__block ---------------->
                                <button id="open-popup-btn_lid" class="swiper-slide blog__button">
                                    <div class="swiper-slide blog__item">
                                    <img class="blog__item-img" src="images/inst-lid-2.jpg" alt="">
                                    <h4 class="blog__item-title text__up">
                                        ЛИДИЯ
                                    </h4>
                                    <p class="blog__item-text text__low">
                                    Lorem ipsum dolor sit amet consectetur 
                                            adipisicing elit. Qui, aliquid! Repellat 
                                            aut facilis sequi quidem id officiis necessitatibus 
                                            officia, rem vel soluta est cumque?
                                    </p>
                                </div>
                                </button>
                            </div>
                            <div class="swiper-button-next" ></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <!-------------- /Slider ---------------->
                </div>
                <!--------------------------- POPUP ----------------------------->
                <div class="popup" id="popup_ksen">
                    <div class="popup__box">
                        <button class="popup__close-bnt" id="close-popup-btn_ksen">
                            <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.09082 0.03125L22.9999 22.0294L20.909 24.2292L-8.73579e-05 2.23106L2.09082 0.03125Z"
                                    fill="#333333" />
                                <path d="M0 22.0295L20.9091 0.0314368L23 2.23125L2.09091 24.2294L0 22.0295Z" fill="#333333" />
                            </svg>
                        </button>
                        <div class="person">
                            <img class="popup-img" src="images/inst-ksen.jpg" alt="">
                            <h4 class="popup-title text__up"> Здравовская Ксения </h4>
                        </div>
                        <div class="person__info">
                            <h4 class="popup__info-title text__up"> Регалии и образование </h4>
                            <p class="popup-text text__low">
                            Конечно, вот пример регалий и образования тренера по плаванию:

Регалии:

1. Мастер спорта международного класса.
2. Призер чемпионатов мира и Олимпийских игр в качестве спортсмена, а также награды за тренерскую деятельность.
3. Более 15 лет опыта работы как тренер по плаванию, успешно подготовивший несколько поколений спортсменов.
4. Ученики тренера стабильно занимают призовые места на соревнованиях международного уровня.

Образование:

1. Дипломированный спортивный тренер по плаванию с отличием.
2. Профессиональное обучение в области физиологии спорта, психологии тренировок, методике плавания.
3. Сертификаты тренера-преподавателя по плаванию от национальной спортивной федерации.

                           </p>
                        </div>
                    </div>
                </div>
                <div class="popup" id="popup_fed">
                    <div class="popup__box">
                        <button class="popup__close-bnt" id="close-popup-btn_fed">
                            <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.09082 0.03125L22.9999 22.0294L20.909 24.2292L-8.73579e-05 2.23106L2.09082 0.03125Z"
                                    fill="#333333" />
                                <path d="M0 22.0295L20.9091 0.0314368L23 2.23125L2.09091 24.2294L0 22.0295Z" fill="#333333" />
                            </svg>
                        </svg>
                        </button>
                        <div class="person">
                            <img class="popup-img" src="images/inst-fed-1.jpg" alt="">
                            <h4 class="popup-title text__up"> Феееедоооор </h4>
                        </div>
                        <div class="person__info">
                            <h4 class="popup__info-title text__up"> Регалии и образование </h4>
                            <p class="popup-text text__low">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi obcaecati 
                                nulla laudantium molestiae ea, est ad quae expedita labore corrupti vitae ipsum
                                voluptatibus, odio tenetur harum. Consectetur praesentium earum consequatur
                                molestiae dolorum, explicabo cumque quas non nobis obcaecati repudiandae odit 
                                uos blanditiis, totam incidunt eaque. Obcaecati repellat quia delectus asperiores 
                                impedit non accusantium quas beatae quaerat cupiditate quibusdam quos maiores excepturi,
                                nemo laudantium porro, sapiente veniam vitae incidunt officia tenetur blanditiis. 
                                Laboriosam sequi provident fugit neque tempore sit laborum quos ipsam necessitatibus
                                porro aperiam consequuntur reiciendis laudantium commodi similique, ab eaque recusandae
                                mollitia at sunt ad eveniet cumque? Odit, culpa.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="popup" id="popup_alim">
                    <div class="popup__box">
                        <button class="popup__close-bnt" id="close-popup-btn_alim">
                            <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.09082 0.03125L22.9999 22.0294L20.909 24.2292L-8.73579e-05 2.23106L2.09082 0.03125Z"
                                    fill="#333333" />
                                <path d="M0 22.0295L20.9091 0.0314368L23 2.23125L2.09091 24.2294L0 22.0295Z" fill="#333333" />
                            </svg>
                        </svg>
                        </button>
                        <div class="person">
                            <img class="popup-img" src="images/inst-alim-1.jpg" alt="">
                            <h4 class="popup-title text__up"> Феееедоооор </h4>
                        </div>
                        <div class="person__info">
                            <h4 class="popup__info-title text__up"> Регалии и образование </h4>
                            <p class="popup-text text__low">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi obcaecati 
                                nulla laudantium molestiae ea, est ad quae expedita labore corrupti vitae ipsum
                                voluptatibus, odio tenetur harum. Consectetur praesentium earum consequatur
                                molestiae dolorum, explicabo cumque quas non nobis obcaecati repudiandae odit 
                                uos blanditiis, totam incidunt eaque. Obcaecati repellat quia delectus asperiores 
                                impedit non accusantium quas beatae quaerat cupiditate quibusdam quos maiores excepturi,
                                nemo laudantium porro, sapiente veniam vitae incidunt officia tenetur blanditiis. 
                                Laboriosam sequi provident fugit neque tempore sit laborum quos ipsam necessitatibus
                                porro aperiam consequuntur reiciendis laudantium commodi similique, ab eaque recusandae
                                mollitia at sunt ad eveniet cumque? Odit, culpa.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="popup" id="popup_lid">
                    <div class="popup__box">
                        <button class="popup__close-bnt" id="close-popup-btn_lid">
                            <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.09082 0.03125L22.9999 22.0294L20.909 24.2292L-8.73579e-05 2.23106L2.09082 0.03125Z"
                                    fill="#333333" />
                                <path d="M0 22.0295L20.9091 0.0314368L23 2.23125L2.09091 24.2294L0 22.0295Z" fill="#333333" />
                            </svg>
                        </svg>
                        </button>
                        <div class="person">
                            <img class="popup-img" src="images/inst-lid-2.jpg" alt="">
                            <h4 class="popup-title text__up"> Феееедоооор </h4>
                        </div>
                        <div class="person__info">
                            <h4 class="popup__info-title text__up"> Регалии и образование </h4>
                            <p class="popup-text text__low">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi obcaecati 
                                nulla laudantium molestiae ea, est ad quae expedita labore corrupti vitae ipsum
                                voluptatibus, odio tenetur harum. Consectetur praesentium earum consequatur
                                molestiae dolorum, explicabo cumque quas non nobis obcaecati repudiandae odit 
                                uos blanditiis, totam incidunt eaque. Obcaecati repellat quia delectus asperiores 
                                impedit non accusantium quas beatae quaerat cupiditate quibusdam quos maiores excepturi,
                                nemo laudantium porro, sapiente veniam vitae incidunt officia tenetur blanditiis. 
                                Laboriosam sequi provident fugit neque tempore sit laborum quos ipsam necessitatibus
                                porro aperiam consequuntur reiciendis laudantium commodi similique, ab eaque recusandae
                                mollitia at sunt ad eveniet cumque? Odit, culpa.
                            </p>
                        </div>
                    </div>
                </div>
                <!------------------------ /POPUP -------------------------->
            </section>
            <!----------------------- /BLOG ------------------------->

            <!-------------------------- VIDEO ---------------------------->
            <section class="video">
                <div class="container">
                    <h2 class="section-title video__title">
                        НАШИ ТРЕНИРОВКИ
                    </h2>
                    <p class="video__text">
                        Незабываемые тренировки с самыми лучшеми тренерами
                    </p>
                    <!-- <iframe class="video__content" width="1000" height="500" 
                    src="https://www.youtube.com/embed/xY4fWRrwwOU?si=Hu4K__l_VMRdYCTV&amp;controls=0" 
                    title="YouTube video player" frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; 
                    gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin" 
                    allowfullscreen></iframe> -->
                    <iframe class="video__content" width="1000" height="500"
                    src="https://www.youtube.com/embed/QIHIWLhvO7c?si=dWkdwCUq4NDmaNGX" 
                    title="YouTube video player" frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; 
                    gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin" 
                    allowfullscreen></iframe>
                </div>
            </section>
            <!-------------------------- /VIDEO ---------------------------->

            <!-------------------------- MAP ---------------------------->
            <section id="map" class="map">
                <div class="container">
                    <h2 class="section-title map__title">
                        Дислокация
                    </h2>
                    <div class="background-map">
                        <div class="map__info">
                            <h3 class="map__contact-1 text__up">Наш адрес:</h3>
                            <h4 class="map__contact-adres">Ярославль, ул.Розылюксембург, 22А</h4>
                            <h4 class="map__contact-2">Связь с нами:</h4>
                            <ul class="map__text text__low"> <img class="map-img" src="images/bx-phone-call.png" alt="">+7 (999) 777-69-69</ul>
                            <ul class="map__text text__low"><img class="map-img" src="images/bx-envelope.png" alt="">@capitanpups</ul>
                        </div>
                        <div class="map__block">
                            <iframe class="map__Yandex" 
                            src="https://yandex.com/map-widget/v1/?um=constructor%3A57cc715910f3c576e1db94b5a0c9267f830c5312a8b06eb06c6c4d139328eae2&amp;
                            source=constructor"
                             max-width="100%" height="430" frameborder="0">
                            </iframe>
                        </div>
                    </div>
                </div>
            </section>
            <!--------------------------/Map---------------------------->
        </main>
        <footer class="footer">
            <div class="container">
                <nav class="footer__menu">
                    <ul class="footer__menu-list">
                        <li class="footer__menu-item">
                            <p class="footer__menu-title">Products</p>
                        </li>
                        <li class="footer__menu-item">
                            <a href="#" class="footer__menu-link">Used</a>
                        </li>
                        <li class="footer__menu-item">
                            <a href="#" class="footer__menu-link">New</a>
                        </li>
                    </ul>

                    <ul class="footer__menu-list">
                        <li class="footer__menu-item">
                            <p class="footer__menu-title">Resurses</p>
                        </li>
                        <li class="footer__menu-item">
                            <a href="#" class="footer__menu-link">Blog</a>
                        </li>
                        <li class="footer__menu-item">
                            <a href="#" class="footer__menu-link">FAQ</a>
                        </li>
                    </ul>

                    <ul class="footer__menu-list">
                        <li class="footer__menu-item">
                            <p class="footer__menu-title">About</p>
                        </li>
                        <li class="footer__menu-item">
                            <a href="#" class="footer__menu-link">Team</a>
                        </li>
                        <li class="footer__menu-item">
                            <a href="#" class="footer__menu-link">Careers</a>
                        </li>
                    </ul>
                </nav>
                <ul class="app">
                    <li class="app_item">
                        <a href="#" class="app_item-link">
                            <img src="images/vk-logo-60.png" alt="" class="app__item-img">
                        </a>
                    </li>
                    <li class="app_item">
                        <a href="#" class="app_item-link">
                            <img src="images/instagram-logo-60.png" alt="" class="app__item-img">
                        </a>
                    </li>
                </ul>
                <div class="footer__copy">
                    <p class="footer__copy-text">
                        Я вообще без понятия что тут должно быть написано,даже песать спыцально нееправильнго буду 
                        что за тексмт, копирайт ккой0тоЮ, может чтоб не укрвли, но япишу и так криво, кому это красть то нужно
                    </p>
                    <p class="footer__copy-text">
                        Я вообще без понятия что тут должно быть написано,даже песать спыцально нееправильнго буду 
                        что за тексмт, копирайт ккой0тоЮ, может чтоб не укрвли, но япишу и так криво, кому это красть то нужно
                    </p>
                </div>

            </div>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11
    /swiper-bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>