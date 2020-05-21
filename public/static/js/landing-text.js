const text = document.querySelector("#landing-title");
const navBar = document.querySelector("#nav");
const landingBG = document.querySelector("#landing-title-bg");
const strText = text.textContent;
const splitText = strText.split("");
text.textContent = "";

for (let i = 0; i < splitText.length; i++) {
    console.log(splitText[i]);
    if (splitText[i] == " ") {
        text.innerHTML += "<span id='title-character' class='px-1'>" + splitText[i] + "</span>"
    }
    else {
        text.innerHTML += "<span id='title-character'>" + splitText[i] + "</span>";
    }
}

let char = 0;
let timer = setInterval(onTick, 50);

function onTick() {
    const span = text.querySelectorAll('span')[char];
    console.log(span);
    span.classList.add('fade');
    char++;
    if (char === splitText.length) {
        complete();
        setInterval(function () {
            landingBG.classList.add('landing-bg');
        }, 300);
        setInterval(function () {
            nav.classList.add('bg-mint');
        }, 1000);
    }
}

function complete() {
    clearInterval(timer);
    timer = null;
}
