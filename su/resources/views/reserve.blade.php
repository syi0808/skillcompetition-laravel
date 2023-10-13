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

        .calendar-header {
            display: flex;
            width: 100%;
        }

        .calendar-header > div {
            width: 100%;
        }

        .calendar-wrapper {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(5, 1fr);
            border: 1px solid black;
        }

        .calendar-wrapper > div {
            height: 80px;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
        }

        .selected {
            background: red;
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
<div>
    <button onclick="prevMonth()"><</button>
    <h1 id="month">2023.10</h1>
    <button onclick="nextMonth()">></button>
    <div class="calendar-header">
        <div>일요일</div>
        <div>월요일</div>
        <div>화요일</div>
        <div>수요일</div>
        <div>목요일</div>
        <div>금요일</div>
        <div>토요일</div>
    </div>
    <div class="calendar-wrapper">
    </div>
</div>

<div id="reserveTooltip">
    <div id="reserveTooltipDate">2023-10-11</div>
    <select id="date" oninput="selectDateRange(Number(event.target.value))">
        <option value="1">1박2일</option>
        <option value="2">2박3일</option>
        <option value="3">3박4일</option>
    </select>
    <select id="campNumber" oninput="selectCampNumber(Number(event.target.value))">
    </select>
</div>

<div id="campMap">
</div>


<div id="campInformation">예약 시설 정보</div>
<div id="dateRange">예약 일정</div>
<div id="price">13000원</div>

<form onsubmit="reserve(event)">
    <input name="peopleCount" type="number" min="1" max="6" placeholder="예약인원">
    <input disabled value="{{ Auth::user()->tel }}">
    <input disabled value="{{ Auth::user()->name }}">
    <input name="carNumber" type="text" placeholder="차량번호">
    <button>예약하기</button>
</form>

<a href="/list">예약현황 보기</a>

<script>
    const campground = "{{ $campground }}";
</script>
<script src="{{ asset("js/calendar.js") }}"></script>
</body>
</html>
