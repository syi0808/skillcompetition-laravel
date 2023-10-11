let images = [];
const imagesWrapper = document.getElementsByClassName('images')[0];
const dropzone = document.getElementsByClassName('drop-zone')[0];

let dragStartedImage = null;
let isDroped = false;

function onDragover(e) {
  e.preventDefault();
}

function onDrop(e) {
  isDroped = true;

  // 만약에 이미지를 드롭다운 한 곳이 드롭다운 된 이미지 위라면
  if (e.target !== e.currentTarget) {
    // 드래그 하고 있는 이미지
    const movedImageIndex = images.findIndex((image) => image === dragStartedImage.src);
    // 드롭다운 당한 이미지
    const targetImageIndex = [...e.target.parentElement.children].findIndex(
      (imageElement) => imageElement.src === e.target.src
    );

    // 만약에 드롭다운한 이미지가 드롭다운된 이미지들 중에 하나라면
    if (movedImageIndex !== -1) {
      const movedImage = images.splice(movedImageIndex, 1)[0];
      images.splice(targetImageIndex, 0, movedImage);
    }
    // 드롭다운한 이미지가 목록에서 가져온 이미지라면
    else {
      if (images.length === 5) {
        alert('이미지는 5개까지 등록할 수 있습니다.');
        return;
      }
      images.splice(targetImageIndex, 0, dragStartedImage.src);
    }
  }
  // 드롭 다운 영역에 이미지가 드롭됐다면
  else {
    if (images.length === 5) {
      alert('이미지는 5개까지 등록할 수 있습니다.');
      return;
    }
    images.push(dragStartedImage.src);
  }

  if (dragStartedImage.parentElement === imagesWrapper) {
    imagesWrapper.removeChild(dragStartedImage);
  }

  renderImages();
}

function onImageDragstart(e) {
  dragStartedImage = e.target;
  isDroped = false;
}

function onImageDragend(e) {
  if (!isDroped) {
    const deletedImage = images.splice(
      images.findIndex((image) => image === dragStartedImage.src),
      1
    );

    const image = document.createElement('img');

    image.src = deletedImage;

    imagesWrapper.appendChild(image);

    renderImages();
    addEventlistenerToImages();
  }
}

function onImageDragover(e) {}

function addEventlistenerToImages() {
  const images = document.getElementsByClassName('images')[0].getElementsByTagName('img');

  [...images].forEach((image) => {
    image.removeEventListener('dragstart', onImageDragstart);
    image.removeEventListener('dragover', onImageDragover);
    image.removeEventListener('dragend', onImageDragend);

    image.addEventListener('dragstart', onImageDragstart);
    image.addEventListener('dragover', onImageDragover);
    image.addEventListener('dragend', onImageDragend);
  });
}

function renderImages() {
  dropzone.innerHTML = images
    .map(
      (imageSrc) =>
        `<img draggable="true" ondragend="onImageDragend(event)" ondragstart="onImageDragstart(event)" src="${imageSrc}">`
    )
    .join('');
}

addEventlistenerToImages();

async function addTourlist() {
  if (images.length < 5) {
    alert('이미지를 5개까지 채워주세요.');
    return;
  }

  await fetch('/api/recommend_trip', {
      method: "post",
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({
          trips: images.map((image, index) => ({
              score: 5 - index,
              name: image.split('/').at(-1).split('.')[0],
          }))
      }),
  });

  fetchData();
  closeModal();
}

function closeModal() {
  document.getElementsByClassName('modal')[0].style.display = 'none';
}

function openModal() {
  document.getElementsByClassName('modal')[0].style.display = 'block';
}
