/* Function to add the class "hidden" to a card if the element "P" belongs to the class of the map
 */
const restrictP = (e) => {
    let cards = document.getElementsByClassName('card');
    for(let card of cards){
        let string=card.classList[1];
        string.includes("P") ? console.log('ok'):card.classList.add("hidden");
    }
}
const restrictR = (e) => {
    let cards = document.getElementsByClassName('card');
    for(let card of cards){
        let string=card.classList[1];
        string.includes("R") ? console.log('ok'):card.classList.add("hidden");
    }
}
const restrictT = (e) => {
    let cards = document.getElementsByClassName('card');
    for(let card of cards){
        let string=card.classList[1];
        string.includes("T") ? console.log('ok'):card.classList.add("hidden");
    }
}

let plain = document.getElementById('P');
plain.addEventListener('click', restrictP);
let strip = document.getElementById('R');
strip.addEventListener('click', restrictR);
let stain = document.getElementById('T');
stain.addEventListener('click', restrictT);