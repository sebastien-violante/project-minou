/* The purpose of the script is to make visible or invisible the division placed just after the arrow after a click on it */
const deploysearch = (e) => {
    if(e.target.nextElementSibling.className === "hidden"){
        e.target.nextElementSibling.className = "visible";
        precise.classList.add('up');
    } else {
        e.target.nextElementSibling.className = "hidden";
        precise.classList.remove('up');
    }
}
let precise = document.getElementById('precise-arrow');
precise.addEventListener('click', deploysearch);


