let data = [];
const recommendWrapper = document.getElementsByClassName('recommend-tourlist-wrapper')[0];

async function fetchData() {
  const response = await (await fetch('/api/recommend_trip')).json();

  data = response.trips;
  render();
}

function render() {
  recommendWrapper.innerHTML = '';

  data.forEach((data, index) => {
    const userid = data.user_name;
    const photoset = data.trips;

    const div = document.createElement('div');

    div.setAttribute('class', 'recommend-tourlist');

    div.innerHTML = `
      <button onclick="play(${index})" class="recommend-play-button">재생하기</button>
      <img src="/images/${photoset[0].name}.jpg" />
      <span class="nickname">${userid}</span>
    `;

    recommendWrapper.appendChild(div);
  });
}

function play(index) {
  let currentPage = 0;

  const image = document.getElementsByClassName('recommend-tourlist')[index].getElementsByTagName('img')[0];

  const timer = setInterval(() => {
    currentPage += 1;

    if (currentPage > 4) {
      clearInterval(timer);
    }

    image.src = `/images/${data[index].trips[currentPage % 5].name}.jpg`;
  }, 1000);
}

fetchData();
