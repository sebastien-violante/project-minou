let allGridItems = [...document.getElementsByClassName("grid-item")];
let popupBg = document.getElementById("popup-bg");
let popupImg = document.getElementById('popup-img');
/* Function to display the image as a pop-up */
const openPopup = (e) => {
    let gridItemClicked = e.target.closest(".grid-item");
    let clickedImageName = gridItemClicked.id;
    popupBg.classList.add('active');
    popupImg.src = `./pictures/${clickedImageName}.jpg`;
}
/* Function to hide the pop-up with an image */
const closePopup = () => {
    popupBg.classList.remove('active');
}

allGridItems.forEach(element => element.addEventListener('click', openPopup));
popupImg.addEventListener('click', (e) => e.stopPropagation());
popupBg.addEventListener('click', closePopup);
