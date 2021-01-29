var mymap;


// Base Layers

var lyrOSM;
var lyrWatercolor;
var lyrTopo;
var lyrImagery;
var lyrOutdoors;

// Additional Layers
var ThimphuTower;

// Styling

var towermarker;

//Buttons and Control Bars
var ctlEasyButtonLocate;
var ctlAttribite;
var ctlSidebar;
var ctlMeasure;
var ctlLayers;
var ctlPan;



$(document).ready(function(){
    
    //  Map Initialization 
    
    mymap = L.map('mapdiv', {center:[27.5,90.4], zoom:9, attributionControl:false});

    // Sidebar
    
   // ctlSidebar = L.control.sidebar('side-bar').addTo(mymap);
    


    // Pan Control

    ctlPan = L.control.pan({position:'bottomleft'}).addTo(mymap);
    
    //  Layer Initialization 
    
    lyrOutdoors = L.tileLayer.provider('Thunderforest.Outdoors');
    lyrOSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
    lyrTopo = L.tileLayer.provider('OpenTopoMap');
    lyrImagery = L.tileLayer.provider('Esri.WorldImagery');
    lyrWatercolor = L.tileLayer.provider('Stamen.Watercolor');
    mymap.addLayer(lyrImagery);
// Tower Marker

towermarker = L.icon({
    iconUrl: './asset/geowgcenters.png',
    iconSize:[15, 30], // size of the icon
});

// Adding Geojson from postgres

    $.ajax({url:'./data/load_thimphu_tower.php',
        success: function(response){
          jsnThimphuTower = JSON.parse(response);
          ThimphuTower = L.geoJSON(jsnThimphuTower, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {icon: towermarker});
            },
            onEachFeature(feature, layer) {
                layer.on({
                    click: function populate(){
                        document.getElementById('sidebar').innerHTML = 'Name : ' + feature.properties.geog_cente + '</br>'+ 'Dzongkhag : ' + feature.properties.dzongkhag +'</br>' + 'Geowg : ' + feature.properties.geog + '</br>' + 'Village: ' + feature.properties.village + '</br>' + 'Gup Name : ' + feature.properties.gup_s_name + '</br>' +'Electricity Availability/Type : ' + feature.properties.electricit + '</br>' + 'Computer Availability: ' + feature.properties.computer;
                },

                });
              },
        }).addTo(mymap);
        
       

        ctlLayers.addOverlay(ThimphuTower, 'Tele-communication Tower') /// adding to layer control
        
        },

        error: function(xhr, status, error){
            alert('ERROR:'+ error);
        }
    });


   
// Setup Layer Control 
    
    objBasemaps = {
        "Outdoors":lyrOutdoors,
        "Open Street Maps": lyrOSM,
        "Topo Map":lyrTopo,
        "Imagery":lyrImagery,
        "Watercolor":lyrWatercolor
    };
    
    objOverlays = {
    };
    
    ctlLayers = L.control.layers(objBasemaps,objOverlays).addTo(mymap);
    

// Easy Button to control sidebar
    
    ctlEasyButtonLocate = L.easyButton("glyphicon-map-marker", function(){
        mymap.locate();
    }, {position: 'topleft'}).addTo(mymap);
    
 

// Measure Polyline control

    ctlMeasure = L.control.polylineMeasure({position: 'topleft'}).addTo(mymap);

//Location Events

    mymap.on('locationfound', function(e) {

        var radius = e.accuracy /2;
        L.marker(e.latlng).addTo(mymap).bindPopup("You are within " + radius + " meters from this point").openPopup();
        L.circle(e.latlng, radius).addTo(mymap);
        mymap.setView(e.latlng, 18);
    });


    mymap.on('locationerror', function(e) {
        console.log(e);
        alert("Location was not found");
    })
    
    });

//  General Functions 
            
function LatLngToArrayString(ll) {
return "["+ll.lat.toFixed(5)+", "+ll.lng.toFixed(5)+"]";
}

