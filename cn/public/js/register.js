let prevId = '';
let prevPassword = '';
let prevName = '';
let prevPhone = '';

const idCheck = {
  id: '',
  checked: false,
  isAble: false,
};

function openRegisterModal() {
  document.getElementById('register-modal').style.display = 'flex';
}

function closeRegisterModal() {
  document.getElementById('register-modal').style.display = 'none';
}

function onChangeId(e) {
  idCheck.checked = false;
  idCheck.isAble = false;

  if (e.target.value !== '' && (!/^[a-z0-9_-]+$/.test(e.target.value) || e.target.value.length > 20)) {
    e.target.value = prevId;
  } else {
    prevId = e.target.value;
  }
}

function onChangePassword(e) {
  if (e.target.value !== '' && e.target.value.length > 8) {
    e.target.value = prevPassword;
  } else {
    prevPassword = e.target.value;
  }
}

function onChangeName(e) {
  if (e.target.value !== '' && (!/^[가-힣ㄱ-ㅎ]*$/.test(e.target.value) || e.target.value.length > 5)) {
    e.target.value = prevName;
  } else {
    prevName = e.target.value;
  }
}

function onChangePhone(e) {
  if (e.target.value !== '' && e.target.value.length > 13) {
    e.target.value = prevPhone;
  } else {
    const onlyNumber = e.target.value.replace(/\D/g, '');
    const formattedPhone = onlyNumber.replace(/(\d{0,3})(\d{0,4})(\d{0,4})/, '$1-$2-$3').replace(/(\-{1,2})$/g, '');
    prevPhone = formattedPhone;
    e.target.value = formattedPhone;
  }
}

async function checkId() {
    const id = document.getElementById('register-id').value;
    idCheck.id = id;
  const data = await (await fetch(`/api/check_id?id=${id}`)).json();

  document.getElementById('idMessage').innerHTML = data.message;

  if (data.result === 'able') {
    idCheck.isAble = true;
  } else {
    idCheck.isAble = false;
  }

  idCheck.checked = true;

  alert(data.message);
}

async function register(e) {
  e.preventDefault();

  const id = e.srcElement.id.value;
  const password = e.srcElement.password.value;
  const name = e.srcElement.name.value;
  const phone = e.srcElement.phone.value;
  const address = e.srcElement.address.value;
  let hasError = false;

  // 아이디가 없다면
  if (!id) {
    document.getElementById('id-error').innerHTML = '아이디는 필수입니다.';
    hasError = true;
  } else {
    document.getElementById('id-error').innerHTML = '';
  }

  // 비밀번호가 없다면
  if (!password) {
    document.getElementById('password-error').innerHTML = '비밀번호는 필수입니다.';
    hasError = true;
  }
  // 비밀번호가 영문자 1자 미만, 숫자 1자 미만 이라면
  else if (!/[A-Za-z]+/.test(password) || !/[0-9]+/.test(password)) {
    document.getElementById('password-error').innerHTML = '비밀번호는 영어 1자이상 숫자 1자이상을 포함해야 합니다.';
    hasError = true;
  } else {
    document.getElementById('password-error').innerHTML = '';
  }

  if (!name) {
    document.getElementById('name-error').innerHTML = '이름은 필수입니다.';
    hasError = true;
  } else {
    document.getElementById('name-error').innerHTML = '';
  }

  if (!phone) {
    document.getElementById('phone-error').innerHTML = '전화번호는 필수입니다.';
    hasError = true;
  }
  // 연락처가 제대로 입력되지 않았다면
  else if (phone.length !== 13) {
    document.getElementById('phone-error').innerHTML = '전화번호가 올바르지 않습니다.';
    hasError = true;
  } else {
    document.getElementById('phone-error').innerHTML = '';
  }

  if (hasError) {
    return;
  }

  try {
      const data = await fetch("/api/register", {
          method: "POST",
          headers: {
              'Content-Type': "application/json",
          },
          body: JSON.stringify({
              id,
              password,
              tel: phone,
              name,
              address,
          }),
      });

      if(data.status.toString().startsWith('4')) {
          throw new Error("");
      }

      alert('회원가입에 성공하였습니다 !');
      closeRegisterModal();
  } catch(e) {
      alert('회원가입이 실패하였습니다 !');
  }
}
