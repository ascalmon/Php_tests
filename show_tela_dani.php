<?php
class Table{

      private $arrayData;
      private $columns;
      private $lines;
      private $header;
      private $aux;

      function __construct($columns = 0, $lines = 0, $header = true, $arrayData = null){
        $this->arrayData = $arrayData;
        $this->columns = $columns;
        $this->lines = $lines;
        $this->header = $header;
      }

      public function createTable($columns,$lines,$header,$arrayData){
        echo "<table style='width:100%'>";
        if ($header){
            echo "<tr>";
            foreach ($arrayData[0] as $key => $value){
              echo "<th>";
              echo $key;
              echo "</th>";
            }
            echo "</tr>";
        }
        echo "<tr>";
        for ($i=0; $i <= $lines - 1; $i++){
            $size = 100/$columns;
            foreach ($arrayData[$i] as $key => $value){
              echo "<td width='" . (int)$size ."%'>";
              echo $value;
              echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
      }

}
  function connect_db(){
      header('Content-Type: text/html; charset=utf-8');               // Caracters Latinos
          $servername = "localhost";                                  // Uso para teste no servidor local
          $username = "root";
          $password = "";
          $dbname = "admin_login";

      $dbc = new mysqli($servername, $username, $password, $dbname);
      mysqli_select_db($dbc,$dbname);
      mysqli_query($dbc,"SET NAMES 'utf8'");
      mysqli_query($dbc,'SET character_set_connection=utf8');
      mysqli_query($dbc,'SET character_set_client=utf8');
      mysqli_query($dbc,'SET character_set_results=utf8');

      if ($dbc->connect_error) {
           die('Connection failed: ' . $dbc->connect_error);
      }
      return $dbc;
    }

    function get_medidores($dbc,$cidade){
        if ($cidade == ""){
            $sql = "SELECT id, nome_medidor, cidade, latitude, longitude FROM `medidores` WHERE 1";
        }else{
          $sql = "SELECT * FROM `medidores` WHERE cidade ='$cidade'";
        }
          //echo $sql;
          $result = mysqli_query($dbc, $sql);                       // Connecta com o DB e verifica se usuario existe
          if ($result != false){
              $count = mysqli_num_rows($result);
              if ($count == 0) {
                  return false;
              }else{
                  for ($i = 0; $i <= $count - 1; $i++){
                    $array[$i] = mysqli_fetch_assoc($result );
                  }
                  return $array;
              }
          } else {
            echo "Acesso ao Banco abas falhou!";
          }
      }

    function cria_tela($columns,$lines,$header, $array){
      echo "<table style='width:100%'>";
      if ($header){
          echo "<tr>";
          foreach ($array[0] as $key => $value){
          //for($i=0; $i<= $columns; $i++){
            echo "<th>";
            //echo "Header " . $i;
            echo $key;
            echo "</th>";
          }
          echo "</tr>";
      }
      //echo "<tr>";
      for($i=0; $i<= $lines - 1; $i++){
        echo "<tr>";
        $size = 100/$columns;
        for ($j=0; $j<= $columns -1; $j++){
          echo "<td width='" . (int)$size ."%'>";
          echo "Dados " . $j;
          echo "</td>";
        }
        echo "</tr>";
      }
      //echo "</tr>";
      echo "</table>";
    }

?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="bootstrap_4/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <script src="javascript/init_map.js"></script>
    <script src="bootstrap_4/js/jquery.slim.min.js"></script>
    <script src="bootstrap_4/js/popper.min.js"></script>
    <script src="bootstrap_4/js/bootstrap.min.js"></script>
    <title>Show Tela</title>
    <style>
        body{
          background-color: lightblue;
        }
        table {
          width: 800px;
          border: solid 1px white;
        }
        tr,th {
          border: solid 1px white;
          color:navy;
          text-align:center;
          font-family: verdana;
  				font-size: 15px;
  				display:inline-block;

        }
        td {
          border: solid 1px white;
          color:navy;
          text-align:center;
          font-family: verdana;
  				font-size: 15px;
  				display:inline-block;
        }


    </style>
    <script>


    </script>
  </head>
  <body>

    <h1 class="text-center"> Teste de Apresentação de Telas </h1>
    <form method="post">
      <label>Cidade:</label>
      <input type="text" name="city" placeholder="Entre nome cidade"></input>
      <input type="submit" value="Submit">
    </form>



    <?php

    if(isset($_POST['city'])){
      $cidade = $_POST['city'];
      echo $cidade;
    } else {
      $cidade = "";
    }

    $dbc = connect_db();
    $listaMedidores = get_medidores($dbc,$cidade);

    //var_dump ($array);
    echo "<br>";
    echo "Id = ";
    echo ($listaMedidores[0]['id']);   //id
    echo "<br>";
    echo "Cidade = ";
    echo ($listaMedidores[0]['cidade']);   //id
    echo "<br>";
    echo "Latitude = ";
    echo $listaMedidores[0]['latitude'];   //
    echo "<br>";
    echo "Longitude = ";
    echo $listaMedidores[0]['longitude'];   //id
    echo "<br>";

    $table = new Table;
    $columns = sizeof($listaMedidores[0]);
    $lines = sizeof($listaMedidores);
    //echo $columns . " - " . $lines;
    //echo "<pre>" . print_r($array, true) . "</pre>";
    $table->createTable($columns,$lines,true,$listaMedidores);
    ?>


<!-- Geolocalização -->


  <h1 class="text-center" id="geo_headline">Localização de <?php echo ($listaMedidores[0]['cidade']);?></h1>

  <div class="row justify-content-center">

        <div class="container col-8" id="map">

        </div>

  </div>

  <script>


    function initMap() {

      let latitude =  parseFloat("<?php echo ($listaMedidores[0]['latitude']);?>");   //traduz PHP para Javascript convertendo a informação de String para Float
      let longitude = parseFloat("<?php echo ($listaMedidores[0]['longitude']);?>");
      let name = ("<?php echo ($listaMedidores[0]['cidade']);?>");
      let geolocation = {lat: latitude, lng: longitude};

      let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 9,
        center: geolocation
      });
      /*
      var markers = [

        { coords: {lat: -23.4844379, lng: -46.8505191},
          icon: "waterdrop.png",
          content: '<h3>Pin 1</h3>'
        }
       ];

       var quantity = ("<?php //echo (sizeof($listaMedidores));?>");

       for (var j = 0; j < quantity; j++){
           markers[j] = {coords: {lat: -23.1500000, lng: -46.2500000},
           icon: "waterdrop.png",
           content: '<h3>Pin 4</h3>'
         };

       }

       for (var i = 0; i < markers.length; i++) {
          //addMarker(markers[i]);
       }

       function addMarker(argument) {

         var marker = new google.maps.Marker({
           position: argument.coords,
           icon: argument.icon,
           map: map,
           animation: google.maps.Animation.DROP
         });

         let infoWindow = new google.maps.InfoWindow({
           content: argument.content
         });

         marker.addListener('click', function() {
            infoWindow.open(map, marker);
         });
     }*/
    }


  </script>

    <!-- Starts the Map and adds the Key -->

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcBVmZl2xcmtWSsTY9eeqvq_ovjCnihhM&callback=initMap">
    </script>


  </body>
</html>
