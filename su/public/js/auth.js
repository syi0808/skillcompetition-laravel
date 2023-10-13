function showLoginModal() {
    document.getElementById("loginModal").style.display = "block";
}
function closeLoginModal() {
    document.getElementById("loginModal").style.display = "none";
}
function showRegisterModal() {
    document.getElementById("registerModal").style.display = "block";
}
function closeRegisterModal() {
    document.getElementById("registerModal").style.display = "none";
}

async function login(e) {
    e.preventDefault();

    const email = e.srcElement.email.value;
    const password = e.srcElement.password.value;

    const data = await (await fetch('/api/login', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email,
            password,
        }),
    })).json();

    if(data.result === "success") {
        alert("로그인 성공");
        window.location.reload();
    } else {
        alert("로그인 실패");
    }
}

async function register(e) {
    e.preventDefault();

    const name = e.srcElement.name.value;
    const tel = e.srcElement.tel.value;
    const password = e.srcElement.password.value;
    const email = e.srcElement.email.value;

    const data = await (await fetch('/api/register', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            name,
            tel,
            password,
            email,
        }),
    })).json();

    if(data.result === "success") {
        alert("회원가입 성공");
        closeRegisterModal();
        showLoginModal();
    } else {
        alert("회원가입 실패");
    }
}
