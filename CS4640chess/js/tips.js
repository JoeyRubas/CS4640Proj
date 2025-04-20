const tips = [
    { msg: "Always do En Passant", author: "Magnus Carlsen" },
    { msg: "Place a mirror behind your opponent so that you can get a sneak peek at their board for a tactical advantage", author: "Vincent" },
    { msg: "Do not play the London", author: "JoeyChess" }
];

const randomTip = () => tips[Math.floor(Math.random() * tips.length)];
const tip = randomTip();

document.getElementById("tip-container").textContent = `"${tip.msg}" — ${tip.author}`;

(function () {
    const tipEl = document.getElementById("tip-container");
    tipEl.style.opacity = 0;
    setTimeout(() => {
        tipEl.style.transition = "opacity 1s";
        tipEl.style.opacity = 1;
    }, 100);
})();