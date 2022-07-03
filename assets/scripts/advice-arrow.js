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