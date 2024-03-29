/* Function to change the value of the "isLost" field of the entity when clicking on the icon */
function changestatus(event) {
    event.preventDefault();
    console.log(event.target);
    let lostLink = event.currentTarget;
    let link = lostLink.href;
    console.log(link);
    // Send an HTTP request with fetch to the URI defined in the href
    fetch(link)
    // Extract the JSON from the response
        .then(res => res.json())
        // Then update the icon
        .then(function(res) {
            console.log(res);
            let icon = event.target;
            /* change of the class of the icon (and thus of the image) according to the clickc */
            if(res.status) {
                icon.classList.remove('bi-house');
                icon.classList.add('binoculars-fill');
            } else {
                icon.classList.remove('binoculars-fill');
                icon.classList.add('bi-house');
            } 
        });
}

let iconLinks = document.getElementsByClassName('changeStatus');
for(let iconLink of iconLinks) {
    iconLink.addEventListener('click', changestatus);
}




