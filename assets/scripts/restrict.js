const restrict = (e) => {
    let cards = document.getElementsByClassName('card');
    for(let card of cards){
        let string=card.classList[1];
        string.includes("P") ? console.log('ok'):card.classList.add("hidden");
        }
    }

let plain = document.getElementById('P');
plain.addEventListener('click', restrict);