<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        .menu-wrapper {
            position: relative;
        }

        .menu-wrapper:hover .menu-content {
            display: block;
        }

        .menu-wrapper:hover span {
            color: red;
        }

        .menu-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.3);
            white-space: nowrap;
        }

        header {
            display: flex;
        }

        section {
            margin: 100px 0;
            border: 1px solid black;
        }

        .carousel-container {
            width: 100%;
            height: 300px;
            position: relative;
            overflow: hidden;
        }

        .carousel-content {
            display: flex;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: left 0.2s ease-in-out;
        }

        .carousel-content div {
            position: relative;
            min-width: 100%;
            object-fit: cover;
        }

        .carousel-content div img {
            width: 100%;
            object-fit: cover;
            position: absolute;
            z-index: -1;
        }

        .carousel-button {
            position: absolute;
        }

        .next-button {
            left: 100px;
        }

        .accordion-wrapper {
            margin: 20px 0;
        }

        .accordion-content {
            display: none;
        }

        .accordion-header {
            cursor: pointer;
        }

        .sns-icon img:hover {
            transform: scale(1.1);
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            box-shadow: 0 5px 8px rgba(0,0,0,0.3);
            display: none;
        }
    </style>
</head>
<body>
<header>
    <span class="logo">위례산자연휴양림</span>
    @if(Auth::check())
        <span>{{Auth::user()->name}}님 안녕하세요</span>
    @else
        <a href="#" onclick="showLoginModal()">로그인</a>
        <a href="#" onclick="showRegisterModal()">회원가입</a>
    @endif
    <a href="#">고객센터</a>
    Language:
    <select>
        <option value="한국어">한국어</option>
    </select>
    <div class="menu-wrapper">
        <div class="menu-content">
            <!-- # 뒤에 있는 id가 있는 섹션으로 찾아감 -->
            @if(Auth::check())
                <a href="/camping.php">온라인예약</a>
            @else
                <a href="#" onclick="showLoginModal()">온라인예약</a>
            @endif
            <a href="#booking">자연휴양림 예약</a>
            <a href="#alarm">알림판</a>
            <a href="#notice">공지사항</a>
            <a href="#event">행사/이벤트</a>
            <a href="#information">여행정보</a>
            <a href="#address">찾아오시는 길</a>
        </div>
        <span>메뉴</span>
    </div>
</header>

<!-- 비쥬얼 영역 -->
<section>
    <div id="visual-carousel" class="carousel-container">
        <div class="carousel-content">
            <div>
                <img src="./assets/images/01.jpg" />
            </div>
            <div>
                <img src="./assets/images/02.jpg" />
            </div>
            <div>
                <img src="./assets/images/03.jpg" />
            </div>
            <div>
                <img src="./assets/images/04.jpg" />
            </div>
            <div>
                <img src="./assets/images/05.jpg" />
            </div>
        </div>
        <button class="carousel-button" onclick="carousels['visual-carousel'].prevSlide()">이전</button>
        <button class="carousel-button next-button" onclick="carousels['visual-carousel'].nextSlide()">다음</button>
    </div>
</section>

<!-- 자연휴양림 예약 -->
<section id="booking">
    <form>
        휴양림유형:
        <select>
            <option value="숲속의 집">숲속의 집</option>
            <option value="오토 캠핑장">오토 캠핑장</option>
        </select>
        이용시작일: <input type="date" /> 이용종료일: <input type="date" />
        <button>예약하기</button>
    </form>
</section>

<!-- 알림판 영역 -->
<section id="alarm">
    <div id="alram-carousel" class="carousel-container">
        <div class="carousel-content">
            <div>
                1. 숲속의 집 운영중지 - 기간 : 2023. 12. 1. ~ 2023. 12. 31. - 사유 : 휴양림 보완공사 시행 - 운영중지 기간은
                공사진행에 따라 변동 될 수 있음
            </div>
            <div>
                2. 산림문화휴양관 정상운영/예약가능 (예약 및 이용 시 유의사항) - 공사로 인한 소음, 진동, 비산먼지, 공사차량
                출입에 따른 불편이 있을 수 있음
            </div>
            <div>
                3. 오토캠핑장 운영중지 - 기간 : 2023. 11. 1. ~ 2023. 11. 31. - 사유 : 휴양림 보완공사 시행 - 운영중지 기간은
                공사진행에 따라 변동 될 수 있음
            </div>
            <div>
                4. 생태수목원 및 등산로 정상운영 (이용 시 유의사항) - 공사구간 이용객 차량 진입 불가 - 매표소 인근 주차장에
                차량 주차 후 도보 이동 - 공사구간을 지날 때 안전사고 발생 우려가 있으니 주의 필요
            </div>
            <div>
                5. 자연휴양림 이용료 인상 - 변경전 10,000원 -> 변경 후 11,000원 - 변경전 13,000원 -> 변경 후 14,000원 -
                2024년 1월 1일 예약부터 적용됩니다.
            </div>
        </div>
        <button class="carousel-button" onclick="carousels['alram-carousel'].prevSlide()">이전</button>
        <button class="carousel-button next-button" onclick="carousels['alram-carousel'].nextSlide()">다음</button>
    </div>
</section>

<!-- 공지사항 -->
<section id="notice">
    <div class="accordion-wrapper">
        <div class="accordion-header">ㅇ [공지] 위례산자연휴양림 부지내 공사로 인한 소음 등 불편 발생 공지 +</div>
        <div class="accordion-content">
            - 위례산자연휴양림 산림문화휴양관 조성공사 등 부지내 공사로 시설물 이용시 공사 소음 등의 불편이 발생하오니
            이용에 참고하시기 바랍니다.
        </div>
    </div>
    <div class="accordion-wrapper">
        <div class="accordion-header">ㅇ [공지] 야영장 이용시 유의사항 +</div>
        <div class="accordion-content">
            - 예약일 출발전 일기예보를 확인하시고 5m/m 이상 강우와 풍속(m/s) 3m 이상시 야영장 이용 여부를 결정하시고
            야영장 자연재해와 이용객 부주의로 인한 안전사고 (나무가지 및 열매낙하로 인한 텐트, 차량파손 등)에 대해서는
            민사상 형사상 책임을 지지 않습니다.
        </div>
    </div>
    <div class="accordion-wrapper">
        <div class="accordion-header">ㅇ [공지] 태위례산자연휴양림 정전 공지 +</div>
        <div class="accordion-content">
            - 위례산자연휴양림 산림문화휴양관 전기 인입 공사로 인해 아래와 같이 부지내 정전이 됩니다. 부대시설물 이용이
            불가할 수 있사오니 양해해주시기 바랍니다.
        </div>
    </div>
</section>

<!-- 행사 / 이벤트 -->
<section id="event">
    <div class="accordion-wrapper">
        <div class="accordion-header">ㅇ [행사] 위례산자연휴양림에서 전국기능경기대회를 응원합니다. +</div>
        <div class="accordion-content">
            - 위례산 자영휴양림에서는 전국기능경기대회를 응원합니다. 다들 최선을 다해서 좋은 성적 기대합니다.
        </div>
    </div>
    <div class="accordion-wrapper">
        <div class="accordion-header">ㅇ [이벤트] 전국기능경기대회 입상자 무료숙박 이벤트 +</div>
        <div class="accordion-content">
            - 위례산자연휴양림에서는 전국기능경기대회 입상자 무료숙박을 지원합니다. 40등까지 무료로 제공할 예정입니다.
        </div>
    </div>
    <div class="accordion-wrapper">
        <div class="accordion-header">ㅇ [이벤트] 자연과 함께하는 포토 이벤트 +</div>
        <div class="accordion-content">
            - 위례산자연휴양림에서는 직접 찍은 자연경관을 사진을 전시합니다. 많은 참여 바랍니다.
        </div>
    </div>
</section>

<!-- 여행 정보 -->
<section id="information">
    <div id="information-carousel" class="carousel-container">
        <div class="carousel-content">
            <div>
                <img src="./assets/travel/각원사.jpg" />
                대명리조트 천안 - 충남 천안시 동남구 성남면 종합휴양지로 200
            </div>
            <div>
                <img src="./assets/travel/광덕산.jpg" />
                대명리조트 천안 - 충남 천안시 동남구 성남면 종합휴양지로 200
            </div>
            <div>
                <img src="./assets/travel/노은정.jpg" />
                대명리조트 천안 - 충남 천안시 동남구 성남면 종합휴양지로 200
            </div>
            <div>
                <img src="./assets/travel/대명리조트 천안.jpg" />
                대명리조트 천안 - 충남 천안시 동남구 성남면 종합휴양지로 200
            </div>
            <div>
                <img src="./assets/travel/성불사.jpg" />
                대명리조트 천안 - 충남 천안시 동남구 성남면 종합휴양지로 200
            </div>
        </div>
        <button class="carousel-button" onclick="carousels['information-carousel'].prevSlide()">이전</button>
        <button class="carousel-button next-button" onclick="carousels['information-carousel'].nextSlide()">
            다음
        </button>
    </div>
</section>

<!-- 찾아오시는 길 -->
<section id="address">
    <img src="{{ asset("images/images/map.jpg") }}" />
</section>

<footer>
    [카피라이터] Copyright ⓒ 2023 all rights reserved. [푸터 메뉴] 이용안내 개인정보 처리방침 저작권 보호정책 도로명
    주소안내 사이트오류 신고
    <div class="sns-icon">
        <img src="{{ asset("images/images/SNS/insta.png") }}" />
    </div>
    <div class="sns-icon">
        <img src="{{ asset("images/images/SNS/facebook.jpg") }}" />
    </div>
    <div class="sns-icon">
        <img src="{{ asset("images/images/SNS/tiktok.png") }}" />
    </div>
</footer>

<form id="loginModal" class="modal" onsubmit="login(event)">
    <input type="email" name="email">
    <input type="password" name="password">
    <button>로그인</button>
</form>

<form id="registerModal" class="modal" onsubmit="register(event)">
    <input placeholder="이메일" type="email" name="email">
    <input placeholder="비밀번호" type="password" name="password">
    <input placeholder="비밀번호 확인" type="password" name="confirmPassword">
    <input placeholder="전화번호" type="text" name="tel">
    <input placeholder="이름" type="text" name="name">
    <button>회원가입<button>
</form>

<script src="{{ asset("js/carousel.js") }}"></script>
<script src="{{ asset("js/accordion.js") }}"></script>
<script src="{{ asset("js/auth.js") }}"></script>
</body>
</html>
