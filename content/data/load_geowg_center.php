<?php

use function PHPSTORM_META\type;

include("../init.php");
$result = $pdo->query('SELECT * , ST_AsGeoJSON(geom , 5) AS geojson FROM geowgcenters');
    
  
  $features=[];
  foreach($result As $row){
        unset($row['geom']);
        $geometry = $row['geojson']= json_decode ($row['geojson']);
        unset($row['geojosn']);
        $feature =['type'=>'Feature','geometry'=>$geometry, 'properties'=>$row];
        array_push($features, $feature);

    }

    $featureCollection = ['type'=>'FeatureCollection','features'=> $features];

    echo json_encode($featureCollection);

?>