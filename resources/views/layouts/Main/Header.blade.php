<div class="container-fluid m-pad">
    <div class="menu-header">
        <div class="dsk-logo">
            <a class="nav-brand" href="/">
                مارلیک افزار
            </a>
        </div>
        <div class="custom-nav" role="navigation">
            <ul class="nav-list">
                <li>
                    <a class="menu-links" href="/">صفحه اصلی</a>
                </li>
                <li>
                    <a class="menu-links" href="/shop">دوره های آموزشی</a>
                </li>
                <li>
                    <a class="menu-links" href="/contact">تماس با ما</a>
                </li>
                <li>
                    <a class="menu-links" href="/about">درباره ما</a>
                </li>
                <li>
                    <a class="menu-links" href="/terms">قوانین</a>
                </li>
            </ul>
            <!-- mobile + desktop - sidebar menu -->
            <ul class="nav-list right-end-btn gap15">
                @guest
                    <li>
                        <a class="btn-br bg-btn3 btshad-b2 lnk" href="/login">
                            ورود
                            <span class="circle">
                  </span>
                        </a>
                    </li>
                    <li>
                        <a class="btn-br bg-btn btshad-b2 lnk" href="/register">
                            عضویت
                            <span class="circle">
                  </span>
                        </a>
                    </li>
                @else
                    <li>
                        <a class="btn-br bg-btn3 btshad-b2 lnk" href="/dashboard">
                            پروفایل
                            <span class="circle"></span>
                        </a>
                    </li>

                @endguest

                <li class="navm- hidedesktop">
                    <a class="toggle" href="#">
                  <span>
                  </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!--Mobile Menu-->
    <nav id="main-nav">
        <ul class="first-nav">
            <li><a href="/">صفحه اصلی</a></li>
            <li><a href="/shop">دوره های آموزشی</a></li>
            <li><a href="/contact">تماس با ما</a></li>
            <li><a href="/about">درباره ما</a></li>
            <li><a href="/terms">قوانین</a></li>
            <li><a href="/course-order">سفارش دوره</a></li>

        </ul>
        <ul class="bottom-nav">
            <li class="prb">
                <a href="tel:+989192138510">
                    <svg viewbox="0 0 384 384" xmlns="http://www.w3.org/2000/svg">
                        <path d="M353.188,252.052c-23.51,0-46.594-3.677-68.469-10.906c-10.719-3.656-23.896-0.302-30.438,6.417l-43.177,32.594
                              c-50.073-26.729-80.917-57.563-107.281-107.26l31.635-42.052c8.219-8.208,11.167-20.198,7.635-31.448
                              c-7.26-21.99-10.948-45.063-10.948-68.583C132.146,13.823,118.323,0,101.333,0H30.813C13.823,0,0,13.823,0,30.813
                              C0,225.563,158.438,384,353.188,384c16.99,0,30.813-13.823,30.813-30.813v-70.323C384,265.875,370.177,252.052,353.188,252.052z">
                        </path>
                    </svg>
                </a>
            </li>
            <li class="prb">
                <a href="https://t.me/caspiweb_ir" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/></svg>
                </a>
            </li>
            <li class="prb">
                <a href="https://instagram.com/caspiweb_ir" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                </a>
            </li>
        </ul>
    </nav>
</div>
