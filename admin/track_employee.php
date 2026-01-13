<?php
include('connect.php');
include("header.php");
include("sidebar.php");



$locationSql = "SELECT  employee_locations.longitude,employee_locations.latitude,employees.firstname FROM employees
                INNER JOIN employee_locations ON employee_locations.employee_id = employees.employee_id
                where employees.admin_id =".$_SESSION['id'];



$result = mysqli_query($conn,$locationSql);
$coordinates = [];
while($row = mysqli_fetch_row($result)){
    $coordinates[] = $row;
}
/*echo '<pre>';
print_r($_SESSION);die;*/
?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.css' rel='stylesheet' />
<style>
    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 100%;
    }
    .footer {
        position: fixed;
        padding: 10px 10px 0px 10px;
        bottom: 0;
    }
    .marker {
        background-image: url('images/marker.png');
        background-size: cover;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }
    .mapboxgl-popup {
        max-width: 200px;
    }

    .mapboxgl-popup-content {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
    }

</style>

<!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Tracking Employee</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Tracking Employees</li>
            </ol>
        </div>
    </div>
    <section class="map_box_container">
        <div id='map'></div>
    </section>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiY29kZXB1bCIsImEiOiJjbGU3Zmt0MjcwNTRyM3BsOHo5b2YyaHpjIn0.o_Y6wv4ztunvter_8YCcow';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [74.4160515, 31.4985013],
            zoom: 9
        });
        map.on('load', function () {
            map.resize();
        });

        var data = <?php echo json_encode($coordinates);?>;
        data.forEach(function(item,index){
            new mapboxgl.Marker({ color: 'red'}).setLngLat(item).setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(item[2])).addTo(map);
            map.flyTo({
                center: item,
                speed: 0.5
            });
        })

    </script>
<?php include("footer.php"); ?>

