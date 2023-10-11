<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        body {
            padding-top: 80px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
        }

        .menu:hover {
            background: red;
        }

        .recommend-tourlist-wrapper {
            display: flex;
            width: 940px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .recommend-tourlist {
            width: 300px;
            position: relative;
        }

        .recommend-tourlist:hover .recommend-play-button {
            display: flex;
        }

        .recommend-play-button {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .recommend-tourlist img {
            width: 300px;
            height: 300px;
            object-fit: cover;
        }

        .modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.3);
            padding: 20px;
            display: none;
        }

        .images img {
            width: 200px;
            height: 200px;
        }

        .drop-zone {
            width: 100%;
            height: 200px;
            background: rgba(123, 0, 123, 0.2);
            padding: 20px;
        }

        .drop-zone img {
            width: 150px;
            height: 150px;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.3);
            display: none;
        }
    </style>
</head>
<body>
<header class="header">
    <a href="./메인.html">
        <span>LOGO</span>
    </a>
    <a class="menu" href="./천안8경.html"><span>천안8경</span></a>
    <a class="menu" href="#"><span>추천여행</span></a>
    <a class="menu" href="#"><span>여행갤러리</span></a>
    <div id="auth-menu">
        <a class="menu" href="#" onclick="openLoginModal()"><span>로그인</span></a>
        <a class="menu" href="#" onclick="openRegisterModal()"><span>회원가입</span></a>
    </div>
</header>

<button onclick="openModal()">나도추천하기</button>
<div class="recommend-tourlist-wrapper"></div>

<div class="modal">
    <div class="images">
        <img draggable="true" src="{{ asset('images/각원사.jpg') }}" />
        <img draggable="true" src="{{ asset('images/광덕사.jpg') }}" />
        <img draggable="true" src="{{ asset('images/산사현대시100년관.jpg') }}" />
        <img draggable="true" src="{{ asset('images/아라리오조각광장.jpg') }}" />
        <img draggable="true" src="{{ asset('images/자연누리성.jpg') }}" />
        <img draggable="true" src="{{ asset('images/중앙시장.jpg') }}" />
    </div>
    <div class="drop-zone" ondragover="onDragover(event)" ondrop="onDrop(event)"></div>

    <button onclick="addTourlist()">추가하기</button>
    <button onclick="closeModal()">닫기</button>
</div>


<form class="modal" id="register-modal" onsubmit="register(event)">
    <input id="register-id" maxlength="20" minlength="1" oninput="onChangeId(event)" name="id" placeholder="아이디" />
    <span id="id-error"></span>
    <button type="button" onclick="checkId()">중복확인</button>
    <span id="idMessage"></span>
    <input
        minlength="1"
        maxlength="8"
        oninput="onChangePassword(event)"
        name="password"
        type="password"
        placeholder="비밀번호"
    />
    <span id="password-error"></span>
    <input name="name" oninput="onChangeName(event)" minlength="1" maxlength="5" placeholder="성명" />
    <span id="name-error"></span>
    <input name="phone" oninput="onChangePhone(event)" placeholder="연락처" />
    <span id="phone-error"></span>
    <input name="address" maxlength="200" placeholder="주소" />
    <button type="submit">회원가입</button>
    <button type="button" onclick="closeRegisterModal()">닫기</button>
</form>

<form class="modal" id="login-modal" onsubmit="login(event)">
    <input id="login-id" maxlength="20" minlength="1" oninput="onChangeId(event)" name="id" placeholder="아이디" />
    <span id="id-error"></span>
    <input
        minlength="1"
        maxlength="8"
        oninput="onChangePassword(event)"
        name="password"
        type="password"
        placeholder="비밀번호"
    />
    <span id="password-error"></span>
    <button type="submit">로그인</button>
    <button type="button" onclick="closeLoginModal()">닫기</button>
</form>

@if(Auth::check() && Auth::user()->role == "admin")
    <div id="rank">

    </div>
    <script src="{{ asset('js/rank.js') }}"></script>
@endif

<script src="{{ asset('js/recommend.js') }}"></script>
<script src="{{ asset('js/dnd.js') }}"></script>
<script src="{{ asset('js/register.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
