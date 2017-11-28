<!DOCTYPE html>
<?php

// Tipos de arrays


$obra = array("tijolo", "cimento", "ferro", "tinta");
echo '<pre>' . print_r($obra,1) . '</pre>';
echo $obra[0];

$construcao = ["tijolo", "cimento", "ferro", "tinta"];
echo '<pre>' . print_r($construcao,1) . '</pre>';
echo $construcao[1];

$casa = array("mat1" => "tijolo", "mat2" => "cimento", "mat3" => "ferro", "mat4" => "tinta");
echo '<pre>' . print_r($casa,1) . '</pre>';
echo $casa['mat3'];

$house = ["mat1" => "tijolo", "mat2" => "cimento", "mat3" => "ferro", "mat4" => "tinta"];
echo '<pre>' . print_r($house,1) . '</pre>';
echo $house['mat4'];

$casas = array('Condes' => array("mat1" => "tijolo", "mat2" => "cimento", "mat3" => "ferro", "mat4" => "tinta"));
$casas['Alphaville'] = array("mat1" => "tijolo", "mat2" => "cimento", "mat3" => "ferro", "mat4" => "tinta");
$casas['Barueri'] = array("mat1" => "tijolo", "mat2" => "cimento", "mat3" => "ferro", "mat4" => "tinta");
$casas['Tambore'] = array("mat1" => "tijolo", "mat2" => "cimento", "mat3" => "ferro", "mat4" => "tinta");
echo '<pre>' . print_r($casas,1) . '</pre>';



$musica = array('artist' => 'Beatles',
              'title' => 'Day tripper',
              'genre' => 'Rock',
              'length' => 3.57,
              'year' => 1964);
echo '<pre>' . print_r($musica,1) . '</pre>';
echo $musica['artist'] . '<br>';
echo $musica['title'] . '<br>';

foreach ($musica as $key => $valor){
    echo 'Dado = ' . $key . ' - Valor = ' . $valor . '<br>';
}


$bandas = array('Beatles' => $musica);
echo '<pre>' . print_r($bandas,1) . '</pre>';

$bandas['Rolling Stone'] = array('artist' => 'Rolling Stone',
                                'title' => "Can't You Hear Me Knocking",
                                'genre' => 'Rock',
                                'length' => 4.57,
                                'year' => 1965);
echo '<pre>' . print_r($bandas,1) . '</pre>';
echo $bandas['Beatles']['artist'] . '<br>';
echo $bandas['Beatles']['title'] . '<br>';
foreach ($bandas as $key => $valor){
    echo 'Banda = ' . $key . '<br>';
    foreach ($valor as $mus => $dados){
        echo 'Dado = ' . $mus . ' - Valor = ' . $dados . '<br>';
    }
}


$myMusic = array('musicas' => $bandas);
echo '<pre>' . print_r($myMusic,1) . '</pre>';
echo $myMusic['musicas']['Beatles']['artist'] . '<br>';
echo $myMusic['musicas']['Beatles']['title'] . '<br>';
foreach ($myMusic as $key => $valor){
    echo 'Musica = ' . $key . '<br>';
    foreach ($valor as $mus => $dados){
        echo 'Banda = ' . $mus . '<br>';
        foreach ($dados as $info => $data){
            echo 'Dado = ' . $info . ' - Valor = ' . $data . '<br>';
        }
    }
}


// Final tipos de arrays



class Song{
    private $mySongs;
    private $title;
    private $genre;
    private $length;
    private $album;
    private $year;



    public function __construct($title= null,$genre = null,$length = null,$album = null,$year=null)
    {
        $this->title = $title;
        $this->genre = $genre;
        $this->length = $length;
        $this->album = $album;
        $this->year = $year;
    }

    public function setNewSong($artist,$title,$genre,$length,$album,$year){
        $this->mySongs['songs'][$artist][$title] = array(
        'title' => $title,
        'genre' => $genre,
        'length' => $length,
        'album' => $album,
        'year' => $year);
    }

    public function showArtistSongs($artist){
        foreach ($this->mySongs['songs'][$artist] as $key => $value){
          echo "Artist = " . $artist . '<br>';
          foreach ( $value as $titulo => $songData){
              echo $titulo . " - " . $songData . '<br>';
          }
          echo '<br>';
        }
    }

    public function getMySongs(){
      return $this->mySongs;
    }

}

$songLibrary = new Song;

$songLibrary->setNewSong("Beatles", "Day tripper", "Rock", 3 , "Yesterday and Today", 1965);
$songLibrary->setNewSong("Beatles", "Help", "Rock", 3 , "Help",1965);
$songLibrary->setNewSong("Beatles", "Hello, Goodbye", "Rock", 3 , "Magical Mystery Tour",1967);
$songLibrary->setNewSong("Rolling Stone", "Can't You Hear Me Knocking", "Rock", 7.15 , "Sticky Fingers",1971);
$songLibrary->setNewSong("Led Zeppelin", "Going to California", "Rock", 7.50 , "Led Zeppelin II",1971);

//echo '<pre>' . print_r($songLibrary->getMySongs(),1) . '</pre>';
//echo '<pre>' . print_r($songLibrary->getMySongs()['songs'][$_GET['band_name']],1) . '</pre>';
//$songLibrary->showArtistSongs('Beatles');
//$songLibrary->showArtistSongs('Rolling Stone');
//$songLibrary->getMySongs();

?>

<html>
<head>
  <style>
      th, td{
          border : solid 1px navy;
          display: inline-block;
          width: 200px;
        }
  </style>
</head>
<body>
    <br>
    <form>
      Band Name: <input type="text" name="band_name"><br><br>
      <input type="submit" value="Search Band" ><br><br>
    </form>

    <?php
        if (isset($_GET['band_name'])){
          if ($_GET['band_name'] != "" ){
            if (array_key_exists($_GET['band_name'],$songLibrary->getMySongs()['songs'])) {
                echo '<div>';
                echo '<h1>' . $_GET['band_name'] . '</h1>';

                echo '<table>';
                echo '<tr>';
                    echo '<th>' . 'Title' . '</th>';
                    echo '<th>' . 'Genre' . '</th>';
                    echo '<th>' . 'Length' . '</th>';
                    echo '<th>' . 'Album' . '</th>';
                    echo '<th>' . 'Year' . '</th>';
                echo '</tr>';

                foreach ($songLibrary->getMySongs()['songs'][$_GET['band_name']] as $key => $value){
                  echo '<tr>';
                  foreach ( $value as $titulo => $songData){
                      echo '<td align="center">' . $songData . '</td>';
                  }
                  echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
              }
            }
        }



    ?>

</body>
</html>
