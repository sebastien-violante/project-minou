/* The purpose of the script is to make visible or invisible the division placed just after the arrow after a click on it */
let arrows = document.getElementsByClassName('advice-arrow');
for(let arrow of arrows) {
    arrow.addEventListener('click', (e) => {
    if(arrow.nextElementSibling.className === "hidden"){
        arrow.nextElementSibling.className = "visible";
        arrow.classList.add('up');
    } else {
        arrow.nextElementSibling.className = "hidden";
        arrow.classList.remove('up');
    }
    console.log(arrow.nextElement.Sibling.className);
})};