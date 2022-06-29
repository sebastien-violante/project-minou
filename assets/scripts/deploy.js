/* Script allowing to unfold or fold an article, and to change the title of the corresponding button
 */const deploy = (e) => {
    let element = e.target.previousElementSibling;  /*when clicking on the button, the previous paragraph is targeted  */
    console.log(element.classList.value);
    if(element.classList.value === 'ellipsis') {  /*remove the class ellipsis -> enable article to deploy */
        element.classList.remove('ellipsis');
        e.target.innerHTML = "Voir moins";
        console.log(element.classList);
    } else {
        element.classList.add('ellipsis');  /*add the class ellipsis -> enable article to fold up */
        e.target.innerHTML = "Voir plus";
        console.log(element.classList);
    };
}

let deployBtns = document.getElementsByClassName('seemore');
for(let deployBtn of deployBtns) {
    deployBtn.addEventListener('click', deploy);
}