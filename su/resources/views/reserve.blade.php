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
    </style>
</head>
<body>
<header>
    <span class="logo">위례산자연휴양림</span>
    <a href="#">로그인</a>
    <a href="#">회원가입</a>
    <a href="#">고객센터</a>
    Language:
    <select>
        <option value="한국어">한국어</option>
    </select>
    <div class="menu-wrapper">
        <div class="menu-content">
            <!-- # 뒤에 있는 id가 있는 섹션으로 찾아감 -->
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



<footer>
    [카피라이터] Copyright ⓒ 2023 all rights reserved. [푸터 메뉴] 이용안내 개인정보 처리방침 저작권 보호정책 도로명
    주소안내 사이트오류 신고
    <div class="sns-icon">
        <img src="./assets/images/SNS/insta.png" />
    </div>
    <div class="sns-icon">
        <img src="./assets/images/SNS/facebook.jpg" />
    </div>
    <div class="sns-icon">
        <img src="./assets/images/SNS/tiktok.png" />
    </div>
</footer>
</body>
</html>
