// pour faire changer le type de bouton lorsque le chat est déclatré perdu ou retrouvé

/* const buttons = document.getElementsByTagName('button');
for (let button of buttons) {
    button.addEventListener('click', (e) => {
        if(e.currentTarget.classList.contains('btn-outline-danger')) {
            e.currentTarget.classList.replace('btn-outline-danger', 'btn-outline-success');
        };
})
}; */

document.querySelector("#isLost").addEventListener('click', changeStatus);

function changeStatus(event) {
    event.preventDefault();
    let statusButton = event.currentTarget;
    let link = statusButton.href;
    // Send an HTTP request with fetch to the URI defined in the href
    fetch(link)
    // Extract the JSON from the response
        .then(res => res.json())
    // Then update the icon
        /* .then(function(res) {
            let watchlistIcon = watchlistLink.firstElementChild;
            if (res.isInWatchlist) {
                watchlistIcon.classList.remove('bi-heart'); // Remove the .bi-heart (empty heart) from classes in <i> element
                watchlistIcon.classList.add('bi-heart-fill'); // Add the .bi-heart-fill (full heart) from classes in <i> element
            } else {
                watchlistIcon.classList.remove('bi-heart-fill'); // Remove the .bi-heart-fill (full heart) from classes in <i> element
                watchlistIcon.classList.add('bi-heart'); // Add the .bi-heart (empty heart) from classes in <i> element
            } 
        });*/
}