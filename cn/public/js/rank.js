 const rankElement = document.getElementById("rank");

async function fetchRank() {
    const { trips } = await (await fetch("/api/recommend_trip/rank")).json();

    rankElement.innerHTML = trips.map(({ trip_name, score }) => `
        <p>${trip_name}: ${score}</p>
    `).join("");
}

fetchRank();
