var mymap;

var lyrOSM;
var lyrWatercolor;
var lyrTopo;
var lyrImagery;
var lyrOutdoors;


var fgpDrawnItems;
 

var ctlEasyButtonLocate;
var ctlEasyButtonSliderbar;
var ctlSidebar;
var ctlMeasure;
var ctlLayers;
var ctlPan;



$(document).ready(function(){
    
    //  Map Initialization 
    
    mymap = L.map('mapdiv', {center:[27.4, 89.39], zoom:12, attributionControl:false});


    // Sidebar
    
    ctlSidebar = L.control.sidebar('side-bar').addTo(mymap);


    // Easy Button to control sidebar
    
    ctlEasyButtonLocate = L.easyButton("glyphicon-map-marker", function(){
        mymap.locate();
    }).addTo(mymap);
    
    ctlEasyButtonSliderbar = L.easyButton("glyphicon glyphicon-transfer", function(){
        ctlSidebar.toggle();
    }).addTo(mymap);

    // Measure Polyline control

    ctlMeasure = L.control.polylineMeasure().addTo(mymap);


    // Pan Control

    ctlPan = L.control.pan({position:'bottomright'}).addTo(mymap);
    
    //  Layer Initialization 
    
    lyrOutdoors = L.tileLayer.provider('Thunderforest.Outdoors');
    lyrOSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
    lyrTopo = L.tileLayer.provider('OpenTopoMap');
    lyrImagery = L.tileLayer.provider('Esri.WorldImagery');
    lyrWatercolor = L.tileLayer.provider('Stamen.Watercolor');
    mymap.addLayer(lyrOutdoors);
    
    fgpDrawnItems = new L.FeatureGroup();
    fgpDrawnItems.addTo(mymap);

// Adding Geojson



    
// Setup Layer Control 
    
    objBasemaps = {
        "Outdoors":lyrOutdoors,
        "Open Street Maps": lyrOSM,
        "Topo Map":lyrTopo,
        "Imagery":lyrImagery,
        "Watercolor":lyrWatercolor
    };
    
    objOverlays = {
        "Drawn Items":fgpDrawnItems
    };
    
    ctlLayers = L.control.layers(objBasemaps, objOverlays).addTo(mymap);
    
//Location Events
mymap.on('locationfound', function(e) {

    var radius = e.accuracy /2;
    L.marker(e.latlng).addTo(mymap).bindPopup("You are within " + radius + " meters from this point").openPopup();
    L.circle(e.latlng, radius).addTo(mymap);
    mymap.setView(e.latlng, 18);
});


mymap.on('locationerror', function(e) {
    console.log(e);
    alert("Location wanot found");
})

});

setInterval(function(){
    mymap.locate()
}, 5000);
//  General Functions 
            
function LatLngToArrayString(ll) {
return "["+ll.lat.toFixed(5)+", "+ll.lng.toFixed(5)+"]";
}

