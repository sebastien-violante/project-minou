let coordx = document.getElementById('search_coordx');
let coordy = document.getElementById('search_coordy');
// if geolocation is activated, init function getPosition to catch current position
function showPosition(position)
{
    // variables initiated to store positions
    let xposition = position.coords.longitude;
    let yposition = position.coords.latitude;
    // update input value to display coords
    coordx.value = xposition;
    coordy.value = yposition;
    console.log(xposition);
    console.log(yposition);
};
if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
else
    {
        x.innerHTML="La géolocation n’est pas prise en charge par ce navigateur.";
    }
    