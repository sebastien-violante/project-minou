//current date modified to compare it with report dates
let currentDate = Date.parse(new Date());

document.addEventListener('DOMContentLoaded', function() {
    var cat = document.querySelector('.js-cat-number');
    var number = cat.dataset.isAuthenticated;
    fetch(`/api/post/${number}`)
    .then((resp) => resp.json())
    .then(function(resp){
        let xPositions = [];
        let yPositions = [];
        let zoomLevel = 14;
        resp.forEach(function(y){
            yPositions.push(parseFloat(y.coordy));
            xPositions.push(parseFloat(y.coordx));
        });
        console.log('longitudes :' + xPositions);
        console.log('latitudes :' + yPositions);
        xCenter = xPositions[xPositions.length - 1];
        yCenter = yPositions[yPositions.length - 1];
        console.log('longitude centrage :' + xCenter);
        console.log('latitude centrage :' + yCenter);
        
        // détermination des écarts max en latitude et longitude
        var xmin = Math.min(...xPositions);
        var ymin = Math.min(...yPositions);
        var xmax = Math.max(...xPositions);
        var ymax = Math.max(...yPositions);
        // détermination des écarts max en distance
        xdelta = (xmax-xmin)*111;
        ydelta = (ymax-ymin)*78;
        console.log('delta longitudes :' + xdelta);
        console.log('delta latitudes :' + ydelta);
        
        // détermination du zoom adéquat
        if(xdelta > 1.830 || ydelta > 1.83){
            zoomLevel = 13;
        }
        if(xdelta > 2.92 || ydelta > 2.92){
            zoomLevel = 12;
        }
        if(xdelta > 5.85 || ydelta > 5.85){
            zoomLevel = 11;
        }
        if(xdelta > 11.71 || ydelta > 11.71){
            zoomLevel = 10;
        }
        if(xdelta > 23.4 || ydelta > 23.4){
            zoomLevel = 09;
        }
        if(xdelta > 46.84 || ydelta > 46.84) {
            zoomLevel = 08;
        }
        if(xdelta > 93.68 || ydelta > 93.68) {
            zoomLevel = 07;
        }
        if(xdelta > 187.373 || ydelta > 187.373) {
            zoomLevel = 06;
        }
                
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2ViYXN0aWVudmlvbGFudGUiLCJhIjoiY2wzbG4wNWg5MGZ0bzNrbThwNzh0ZXFhOCJ9.8M0DRywrHjBdZdQsMOfciQ';
        
        const map = new mapboxgl.Map({
        container: 'map', // container ID
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [xCenter, yCenter], // starting position [lng, lat]
        zoom: zoomLevel // starting zoom
        })
        resp.forEach(function(y){
            let delay =((currentDate - Date.parse(y.date))/3600000);
            let markerColor = 'red';
            if(delay < 48) {
                markerColor = 'blue';
            }
            if(delay < 24) {
                markerColor = 'green';
            }
            // Create a default Marker, colored black, rotated 45 degrees.
            const marker = new mapboxgl.Marker({
                color: markerColor,
                rotation: 45 })
            .setLngLat([y.coordx, y.coordy])
            .setPopup(
                new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML(
                `<h5>${y.date}</h5>`
                )
            )
            .addTo(map);
        })
        
        }
        
    )
    .catch(function(error){

    })
    
});
