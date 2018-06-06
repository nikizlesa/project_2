<?php

$ziel = "tmp/";
$zeit = time();

if (isset($_FILES['HochladeDatei']['name'])) {
    $_FILES['HochladeDatei']['name'] = $zeit . ($_FILES['HochladeDatei']['name']);
    //$zieldatei = $ziel.basename($_FILES["HochladeDatei"]["name"]);

    $fileName = $_FILES['HochladeDatei']['name'];

    $error = 0;

    //  festlegen der Dateiendungen die hochgeladen werden dürfen   EN: Set, which File-Extensions are valid
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $erlaubt = 'csv';

    //  1MB maximaler Upload wird festgelegt    EN: set of the max File-Upload Size
    $max_upload_size = 1 * 1024 * 1024;


    if ($fileActualExt == $erlaubt) {
        if ($_FILES['HochladeDatei']['size'] < $max_upload_size) {
            if ($_FILES['HochladeDatei']['name'] <> '') {
                move_uploaded_file(
                    $_FILES['HochladeDatei']['tmp_name'],
                    $ziel . $_FILES['HochladeDatei']['name']);  //  die ausgewählte Datei wird verschoben   EN: moving the uploaded File

                //echo "<p>Hochladen war erfolgreich: ";
                //echo '<a href="hochgeladenes/'. $_FILES['uploaddatei']['name'] .'">';
                //echo 'hochgeladenes/'. $_FILES['uploaddatei']['name'];
                // echo '</a>';

                $zieldatei = $ziel . $_FILES['HochladeDatei']['name'];
            }
        } else {
            echo '<script> alert("Die ausgewählte Datei ist zu groß. Bitte wählen sie eine kleinere Datei")</script>';
        }   //  Ausgeben einer Fehlermeldung, dass Datei zu groß ist    EN: error message invalid filesize
    } else {
        echo '<script> alert("Ausgewählter Dateityp wird nicht unterstützt! Bitte wählen sie eine CSV-Datei")</script>';
    }   //  Ausgeben einer Fehlermeldung, dass Dateityp nicht konform ist   EN: error message invalid type of data
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TK-A-Look</title>

    <link rel="shortcut icon" type="image/x-icon" href="./images/DB_icon.bmp"/>

    <!--Leaflet einbinden --------------------------------------------------------------------------------------------->

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"/>

    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>

    <!----------------------------------------------------------------------------------------------------------------->

    <!-- MarkerCluster https://github.com/danzel/Leaflet.markercluster -->
    <link rel="stylesheet" href="./libs/MarkerCluster.css"/>
    <link rel="stylesheet" href="./libs/MarkerCluster.Default.css"/>
    <script src="./libs/leaflet.markercluster.js"></script>

    <!-- Load Omnivore plugin to convert CSV to GeoJSON format -->
    <!--<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>-->

    <!-- jQuery 1.8.3: http://jquery.com/ -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>


    <!-- GeoCSV JS-Libary-->
    <script src="./libs/leaflet.geocsv.js"></script>

    <!-- Grouplayers-->
    <link rel="stylesheet" href="./libs/leaflet.groupedlayercontrol.min.css"/>
    <script src="./libs/leaflet.groupedlayercontrol.min.js"></script>

    <!-- Font-Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <!-- Leaflet Search Plugin-->
    <link rel="stylesheet" href="libs/leaflet-search.css"/>
    <script src="libs/leaflet-search.js"></script>

    <!-- Awesome Markers-->
    <link rel="stylesheet" href="libs/leaflet.awesome-markers.css"/>
    <script src="libs/leaflet.awesome-markers.js"></script>


    <link rel="stylesheet" href="style.css"/>


    <style>

        /*Hintergrund der Seite*/
        body {
            background-color: #90a2a9;
        }

        /*Style der Karte*/
        #mapid {
            height: 700px;
            width: 100%;
            border-radius: 10px;
        }

        #imgid {

            margin-right: 10px;
        }

        /*Style des Submit Buttons */
        #submitbtn {
            font-size: 25px;
            border-radius: 5px;
            background-color: white;
            color: #f01414;
            border: 2px solid #f01414;
            -webkit-transition-duration: 0.4s; /* Safari */
            transition-duration: 0.4s;
            position: relative;
            margin-left: 10px;

            cursor: pointer;
            font-family: Arial, sans-serif;

        }

        #submitbtn:hover {
            background-color: #f01414;
            color: white;
            border: 2px solid white;
        }

        #HochladeDatei {

            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: relative;
            z-index: -1;

            left: 10px;
            font-size: 25px;
            color: #f01414;
            border: 2px solid #f01414;
            background-color: white;
            font-family: Arial, sans-serif;
            border-radius: 5px;
            cursor: pointer;
        }

        #label1 {
            position: relative;
            display: inline-block;

            left: 5px;

            font-size: 25px;
            border-radius: 5px;
            cursor: pointer;
            color: #f01414;
            border: 2px solid #f01414;
            background-color: white;
            font-family: Arial, sans-serif;
        }

        #label1:hover {
            border: 2px solid white;
            color: white;
            background-color: #f01414;
        }

        h1 {

            font-size: 28px;
            border-radius: 5px;
            background-color: white;
            color: #f01414;
            border: 2px solid #f01414;
            font-family: Arial, sans-serif;
            text-align: center;
            width: 500px;
            text-decoration: underline;
            text-shadow: 3px 2px #dddddd;
            margin-left: auto;
            margin-right: auto;

        }

        .fa {
            margin-left: 10px;
            margin-right: 10px;
        }

        /*.inputfile + label * {
            pointer-events: none;
        }*/

    </style>

</head>

<body>


<form action="index.php" method="post" enctype="multipart/form-data">
    <div id="imgid"><a href="https://www.dbkommunikationstechnik.de/"><img src="./images/DB.png" height="71px"
                                                                           width="100px"
                                                                           align="right"></a></div>
    <h1>Wilkommen bei DB TK-A-Look</h1>
    <input type="file" name="HochladeDatei" id="HochladeDatei"/><label for="HochladeDatei" id="label1"> <i
                class="fas fa-upload"></i><span id="label_span"> Datei auswählen...  </span></label>
    <input id="submitbtn" type="submit" value="Hochladen" name="Submit"/>

</form>

<br>
<div id="mapid"></div>

<br/>


<script>

    //---Einstellung der Karte mit verschiedenen Tilelayern die auswählbar

    var map = L.map('mapid', {
        minZoom: 6,
        maxZoom: 18,
        //Layers: base_Cartolight
    }).setView([50.986047, 11.034709], 8);

    var base_Google = L.tileLayer('http://{s}.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; 2017 GeoBasis-DE/BKG (&copy;2009), Google'
    });

    var base_Cartolight = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
        attribution: 'Map tiles by Carto, under CC BY 3.0. Data by OpenStreetMap, under ODbL.'
    }).addTo(map);

    var base_OSM_DE = L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    var base_Esri_WorldTopoMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
    });

    var base_Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

    var over_OpenRailwayMap = L.tileLayer('https://{s}.tiles.openrailwaymap.org/standard/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> | Map style: &copy; <a href="https://www.OpenRailwayMap.org">OpenRailwayMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
    });

    var over_OpenMapSurfer_AdminBounds = L.tileLayer('https://korona.geog.uni-heidelberg.de/tiles/adminb/x={x}&y={y}&z={z}', {
        maxZoom: 19,
        attribution: 'Imagery from <a href="http://giscience.uni-hd.de/">GIScience Research Group @ University of Heidelberg</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    var baseLayers = {

        "Basis schwarz/weiss": base_Cartolight,
        "Basis bunt": base_OSM_DE,
        "Reliefkarte": base_Esri_WorldTopoMap,
        "Google Satellit": base_Google,
        "ESRI Satellit": base_Esri_WorldImagery

    };

    var groupedoverlays = {

        "Streckenanzeige": {"<i>Anzeigen</i>": over_OpenRailwayMap},
        "Landkreise": {"<i>Anzeigen</i>": over_OpenMapSurfer_AdminBounds}

    };

    var layerControl = L.control.groupedLayers(baseLayers, groupedoverlays, null,
        {
            collapsed: false,
            autoZIndex: false
        });
    map.addControl(layerControl);
    map.attributionControl.setPrefix('<a href="http://leafletjs.com">Leaflet</a>');

    //kann gelöscht werden
    /* var customLayer = L.geoJson(null, {
         onEachFeature: function (feature, layer) {
             layer.bindPopup("<b><center>" + feature.properties.Anschrift + "</center></b><br> Strecke: " + feature.properties.Streckennr + "<br/><br/>Ortskürzel: " + feature.properties.Ortskuerzel);
         }
     });*/

    var btsMarker = L.AwesomeMarkers.icon({
        icon: 'rss',
        prefix: 'fa',
        markerColor: 'red',
        iconColor: 'white',
        spin: false
    });

    var hoaMarker = L.AwesomeMarkers.icon({
        icon: 'heading',
        prefix: 'fa',
        markerColor: 'purple',
        iconColor: 'white',
        spin: false
    });

    var estwMarker=L.AwesomeMarkers.icon({
        icon:'server',
        prefix:'fa',
        markerColor:'green',
        iconColor:'black',
        spin:false
    });

    var defaultMarker = L.AwesomeMarkers.icon({
        icon: 'train',
        prefix: 'fa',

    });

    <?php
    if (isset($zieldatei)) {

        echo "var clusterLayer = L.markerClusterGroup();

    $.get('./" . $zieldatei . "', function (csvContents) {
        var geoLayer = L.geoCsv(csvContents, {
                firstLineTitles: true,
                fieldSeparator: ',',
                latitudeTitle: 'Ort_Lat',
                longitudeTitle: 'Ort_Lon',
                onEachFeature: function (feature, layer) {
                    layer.bindPopup('<b><center>' + feature.properties.anschrift + '</center></b><br> <b>Strecke:</b><br> ' + feature.properties.streckennr + '<br/><br/><b>Ortskürzel:</b><br> ' + feature.properties.ortskuerzel+'<br><br><b>Servicebezirk:</b><br> '+feature.properties.servicebezirk);
                    
                    var text =feature.properties.anschrift;
                    
                    var result=text.search('HOA');
                    if(result==-1){
                        result=text.search('BTS');
                        if(result==-1){
                            result=text.search('ESTW');
                            if(result==-1){
                                layer.setIcon(defaultMarker);
                            }else{
                                layer.setIcon(estwMarker);
                            }
                        }else{
                            layer.setIcon(btsMarker);
                        }
                    }else{
                        layer.setIcon(hoaMarker);
                    }
                }
            }
        );
        clusterLayer.addLayer(geoLayer);
        map.fitBounds(geoLayer.getBounds());
    });

    clusterLayer.addTo(map);
    
    var controlSearch = new L.Control.Search({
		position:'topleft',		
		layer: clusterLayer,
		initial: false,
		marker: false,
		propertyName:'anschrift',
		zoom:14
	});
	map.addControl( controlSearch );
    ";


    } else {
        echo "<!-- keine Datei gewählt-->";
    }
    // CSV-Cluster Layer

    //funktioniert aber sehr unsicher
    if (isset($zieldatei)) {
        echo "window.onload = function () {
            $.get('data_delete.php?name=" . $zieldatei . "');
            return false;
        }";
    }

    //unlink($zieldatei);
    ?> //PHP-Script zum Einbinden und Verarbeiten des GeoJSON-Layers


    //automatische Skalierung des Kartenfeldes
    $(window).on("resize", function () {
        $("#mapid").height($(window).height() - 155);
        map.invalidateSize();
    }).trigger("resize");


</script>


<script src="index.js"></script>

</body>
</html>
