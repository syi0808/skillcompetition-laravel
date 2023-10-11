function addEventListener() {
    const items = document.getElementsByClassName('item');

    [...items].forEach((item) => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });

        const button = item.getElementsByTagName('button')[0];

        button.addEventListener('click', (e) => {
            e.stopPropagation();

            document.getElementsByClassName('item-wrapper')[0].removeChild(item);
        });
    });
}

function render(data) {
    document.getElementsByClassName("item-wrapper")[0].innerHTML = data.map((image) => `
        <div class="item">
            <button>X</button>
            <img src="/api/images/${image.thumbnail}" />
        </div>
    `).join('');

    addEventListener();
}

async function fetchData() {
    const data = await (await fetch("/api/images")).json();

    render(data.images);
}

async function addImage(e) {
    e.preventDefault();

    const formData = new FormData();

    [...e.srcElement.images.files].forEach(file => {
        formData.append('images[]', file);
    });

    await fetch('/api/images', {
       method: "POST",
       body: formData
    });

    fetchData();
}

fetchData();
