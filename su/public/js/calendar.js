let month = new Date().getMonth() + 1;
const currentMonth = month;

function nextMonth() {
    if(currentMonth + 1 === month) return;

    month += 1;
    renderCalendar(month);
}

function prevMonth() {
    if(currentMonth === month) return;

    month -= 1;
    renderCalendar(month);
}

function getCurrentDatesByMonth(month) {
    const date = new Date();
    date.setMonth(month - 1);
    date.setDate(1);

    const blankCount = date.getDay();
    const lastDay = new Date(
        date.getFullYear(),
        date.getMonth() + 1,
        0
    ).getDate();

    return [
        ...Array.from({ length: blankCount }, () => ""),
        ...Array.from({ length: lastDay }, (_, index) => index + 1),
    ];
}

async function renderCalendar(month) {
    const dates = getCurrentDatesByMonth(month);
    const wrapper = document.getElementsByClassName("calendar-wrapper")[0];

    const data = await (await fetch(`/api/calendar?month=${month}&campground=${campground}`)).json();

    document.getElementById("month").innerHTML = `${new Date().getFullYear()}-${month}`;

    wrapper.innerHTML = "";

    dates.forEach(date => {
        if(date === "") {
            wrapper.innerHTML += `
                <div>
                </div>
            `;
            return;
        }

        const currentDate = new Date();
        currentDate.setMonth(month - 1);
        currentDate.setDate(date);

        const dateString = `${
            currentDate.getFullYear()
        }-${
            (currentDate.getMonth() + 1).toString().padStart(2, '0')
        }-${
            currentDate.getDate().toString().padStart(2, '0')
        }`;
        const restCampCount = 16 - data[dateString];
        const canReserve = restCampCount > 0;

        wrapper.innerHTML += `
            <div>
                <span>${date}</span>
                <span>${restCampCount} / 16</span>
                <button ${canReserve ? `onclick="renderReserveTooltip('${dateString}')"` : ""}>${canReserve ? "예약가능" : "예약불가"}</button>
            </div>
        `
    });
}

renderCalendar(month);

let selectedDate = null;

function renderReserveTooltip(date) {
    renderCampMap(date);

    selectedDate = date;

    const currentDate = new Date(date);
    const dateString = `${
        currentDate.getFullYear()
    }-${
        (currentDate.getMonth() + 1).toString().padStart(2, '0')
    }-${
        currentDate.getDate().toString().padStart(2, '0')
    }`;
    document.getElementById("reserveTooltipDate").innerHTML = dateString;
}

let selectedCampNumber = null;
let selectedDateRange = null;
let selectedCampgroundId = null;

async function renderCampMap(date) {
    const data = await (await fetch(`/api/campgrounds?date=${date}&campground=${campground}`)).json();
    const campMap = document.getElementById('campMap');
    const campSelect = document.getElementById("campNumber");

    campMap.innerHTML = "";
    campSelect.innerHTML = "";

    for(let i = 0; i < 16; i++) {
        const matchedData = data.find(({ number }) => number === i + 1);

        if(matchedData) {
            campMap.innerHTML += `<button class="camp-button" disabled>${i + 1}</button>`;
        } else {
            campSelect.innerHTML += `<option value="${i + 1}">${i + 1}</option>`;
            campMap.innerHTML += `<button class="camp-button" onclick="selectCampNumber(${i + 1})">${i + 1}</button>`;
        }
    }
}

function selectDateRange(dateRange) {
    selectedDateRange = dateRange;

    const currentDate = new Date(selectedDate);
    let dateString = `${
        currentDate.getFullYear()
    }-${
        (currentDate.getMonth() + 1).toString().padStart(2, '0')
    }-${
        currentDate.getDate().toString().padStart(2, '0')
    }`;

    document.getElementById("dateRange").innerHTML = `${dateString}`;

    currentDate.setDate(currentDate.getDate() + dateRange);
    dateString = `${
        currentDate.getFullYear()
    }-${
        (currentDate.getMonth() + 1).toString().padStart(2, '0')
    }-${
        currentDate.getDate().toString().padStart(2, '0')
    }`;

    document.getElementById("dateRange").innerHTML += `- ${dateString} (${dateRange + 1}일간)`;

    let price = 0;
    let isHasWeekend = false;

    for(let i = 0; i < dateRange + 1; i++) {
        const date = new Date(selectedDate);
        date.setDate(date.getDate() + i);

        if(date.getDay() > 4) {
            price += 13000;
            isHasWeekend = true;
        } else {
            price += 10000;
        }
    }

    document.getElementById("price").innerHTML = `${isHasWeekend ? "(주말)" : ""}${price}원`;
}

async function selectCampNumber(number) {
    selectedCampNumber = number;

    document.getElementById("campNumber").value = number;

    [...document.getElementsByClassName("camp-button")].forEach((button, i) => {
        button.classList.remove("selected");

        if(i + 1 === number) {
            button.classList.add("selected");
        }
    });

    document.getElementById("campInformation").innerHTML = `${campground} - ${number}호`;

    const data = await (await fetch(`/api/campground?campground=${campground}&number=${number}`)).json();
    selectedCampgroundId = data.id;
}

async function reserve(e) {
    e.preventDefault();

    const start_date = selectedDate;

    const dateRange = document.getElementById("date").value;
    let end_date = new Date(selectedDate);
    end_date.setDate(end_date.getDate() + selectedDateRange);
    end_date = `${
        end_date.getFullYear()
    }-${
        (end_date.getMonth() + 1).toString().padStart(2, '0')
    }-${
        end_date.getDate().toString().padStart(2, '0')
    }`;

    const people_count = e.srcElement.peopleCount.value;
    const car_number = e.srcElement.carNumber.value;
    const price = document.getElementById("price").innerHTML;
    const campground_id = selectedCampgroundId;

    const data = await (await fetch("/api/reservation", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            start_date,
            end_date,
            car_number,
            people_count,
            price,
            campground_id,
        }),
    })).json();

    if(data.message === "success") {
        alert("예약 성공하였습니다");
    } else {
        alert("예약 실패");
    }
}
