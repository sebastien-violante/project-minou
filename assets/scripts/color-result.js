// variable initialization. One for the final color code, the two others to avoid multichoices on eyes color and body type
let colorResult = [];
const eyesColor = ['B', 'M', 'J', 'V'];
const bodyType = ['P', 'R', 'T'];

let blurbs = document.getElementsByClassName('blurb');
for(let blurb of blurbs) {
    blurb.style.filter = "opacity(20%)";
}
for(let blurb of blurbs) {
    blurb.addEventListener('click', (e) => {
        if( e.currentTarget.style.filter == "opacity(20%)") {
            e.currentTarget.style.filter = "opacity(100%)";
        } else {
            e.currentTarget.style.filter = "opacity(20%)";
        }; 
        // if need is selected, store it. Else, remove it
        if(colorResult.includes(e.currentTarget.id)) {
            colorResult = colorResult.filter(code => code !== e.currentTarget.id);
        } else {
            if(eyesColor.includes(e.currentTarget.id)) {
                const otherEyesColor = eyesColor.filter(element => element !== e.currentTarget.id);
                otherEyesColor.forEach(element =>  {
                    document.getElementById(element).style.filter = "opacity(20%)";
                    colorResult = colorResult.filter(code => code !== element);
                });
            }
            if(bodyType.includes(e.currentTarget.id)) {
                const otherBodyType = bodyType.filter(element => element !== e.currentTarget.id);
                otherBodyType.forEach(element =>  {
                    document.getElementById(element).style.filter = "opacity(20%)";
                    colorResult = colorResult.filter(code => code !== element);
                });
            }
            colorResult.push(e.currentTarget.id);
        };
    let finalcolor = colorResult.join('');
    document.getElementById('cat_colorstyle').value = finalcolor;
    console.log(document.getElementById('cat_colorstyle').value);
})
};
