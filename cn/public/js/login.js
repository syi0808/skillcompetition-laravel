let isLogined = false;

function openLoginModal() {
  document.getElementById('login-modal').style.display = 'flex';
}

function closeLoginModal() {
  document.getElementById('login-modal').style.display = 'none';
}

function changeHeader() {
  if (isLogined) {
    document.getElementById('auth-menu').innerHTML = `
      <a class="menu" href="#" onclick="logout()"><span>로그아웃</span></a>
      <a class="menu" href="#"><span>마이 페이지</span></a>
    `;
  } else {
    document.getElementById('auth-menu').innerHTML = `
      <a class="menu" href="#" onclick="openLoginModal()"><span>로그인</span></a>
      <a class="menu" href="#" onclick="openRegisterModal()"><span>회원가입</span></a>
    `;
  }
}

async function login(e) {
  e.preventDefault();

  const data = await (await fetch("/api/login", {
      method: "POST",
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({
          id: e.srcElement.id.value,
          password: e.srcElement.password.value,
      }),
  })).json();

  alert(data.message);

  if (data.result === 'success') {
    isLogined = true;

    changeHeader();

    closeLoginModal();
  }
}

function logout() {
  isLogined = false;
  changeHeader();
}
