var mymap;


// Base Layers

var lyrOSM;
var lyrWatercolor;
var lyrTopo;
var lyrImagery;
var lyrOutdoors;

// Additional Layers
var geowgcenters;

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
    mymap.addLayer(lyrOSM);
// Tower Marker

geowgcentermarker = L.icon({
    iconUrl: './asset/geowgcenters.png',
    iconSize:[15, 30], // size of the icon
});

// Adding Geojson from postgres

    $.ajax({url:'./data/load_geowg_center.php',
        success: function(response){
          jsngeowgcenters = JSON.parse(response);
          geowgcenters = L.geoJSON(jsngeowgcenters, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {icon: geowgcentermarker});
            },
            onEachFeature(feature, layer) {
                layer.on({
                    click: function populate(){
                        document.getElementById('sidebar').innerHTML = '<strong> Name : </strong>'  + feature.properties.geog_cente + '</br>'
                                                                        + '<strong> Dzongkhag : </strong>' + feature.properties.dzongkhag +'</br>' 
                                                                        + '<strong> Geowg : </strong>' + feature.properties.geog + '</br>' 
                                                                        + '<strong> Village:  </strong>' + feature.properties.village + '</br>' 
                                                                        + '<strong> Gup Name :  </strong>' + feature.properties.gup_s_name + '</br>'
                                                                        +'<strong> Electricity Availability/Type :   </strong>'  + feature.properties.electricit + '</br>' 
                                                                        + '<strong> Computer Availability: </strong>'  + feature.properties.computer;
                },

                });
              },
        }).addTo(mymap);
        
       

        ctlLayers.addOverlay(geowgcenters, 'Geowg Centers') /// adding to layer control
        
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

