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
<div id="reservationList">

</div>

<script>
    async function fetchData() {
        const data = await (await fetch('/api/reservation')).json();

        document.getElementById("reservationList").innerHTML = data.map(data => `
            <div>
                <span>${data.start_date}</span>
                <span>${data.end_date}</span>
                <span>${data.car_number}</span>
                <span>${data.people_count}</span>
                <span>${data.price}</span>
                <button onclick="cancelReservation(${data.id})">취소하기</button>
            </div>
        `).join("");
    }

    async function cancelReservation(reservation_id) {
        const data = await (await fetch(`/api/reservation?reservation_id=${reservation_id}}`, {
            method: "DELETE"
        })).json();

        if(data.message === "success") {
            alert("취소 성공");
            fetchData();
        } else {
            alert("취소 실패");
        }
    }

    fetchData();
</script>
</body>
</html>
