// variable initialization. One for the final color code, the two others to avoid multichoices on eyes color and body type
let colorResult = [];
const eyesColor = ['B', 'M', 'J', 'V'];
const bodyType = ['P', 'R', 'T'];

let caps = document.getElementsByClassName('cap');
for(let cap of caps) {
    cap.style.filter = "opacity(20%)";
}
for(let cap of caps) {
    cap.addEventListener('click', (e) => {
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
                // avoid multi choices of eye colors
                const otherEyesColor = eyesColor.filter(element => element !== e.currentTarget.id);
                otherEyesColor.forEach(element =>  {
                    document.getElementById(element).style.filter = "opacity(20%)";
                    colorResult = colorResult.filter(code => code !== element);
                });
            }
            if(bodyType.includes(e.currentTarget.id)) {
                // avoid multi choices of body types
                const otherBodyType = bodyType.filter(element => element !== e.currentTarget.id);
                otherBodyType.forEach(element =>  {
                    document.getElementById(element).style.filter = "opacity(20%)";
                    colorResult = colorResult.filter(code => code !== element);
                });
            }
            colorResult.push(e.currentTarget.id);
        };
    let finalcolor = colorResult.join('');
    console.log(finalcolor);
    document.getElementById('colorstyle').value = finalcolor;
    console.log(document.getElementById('colorstyle').value);
})
};