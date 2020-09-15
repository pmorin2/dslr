<?php
include 'csv_to_array.php';
include 'array_sort_val_key.php';
include 'array_count_val_key.php';
include 'array_minmax_val_key.php';

if ((isset($argc) && $argc === 2) || isset($_GET["csv"])) {
  if (isset($argc) && $argc === 2) {
    $data = csv_to_array($argv[1], ',');
  }
  else {
    $data = csv_to_array($_GET["csv"], ',');
  }
}
if (isset($_GET["feature"])) {
  $featureNbr = $_GET["feature"];
}
else {
  $featureNbr = 10;
}
$Gryffindor = array();
$Hufflepuff = array();
$Ravenclaw = array();
$Slytherin = array();

$features = array('Arithmancy', 'Astronomy', 'Herbology', 'Defense Against the Dark Arts', 'Divination', 'Muggle Studies', 'Ancient Runes', 'History of Magic', 'Transfiguration', 'Potions', 'Care of Magical Creatures', 'Charms', 'Flying');
$title = "répartitions des notes par maison pour la matière: ".$features[$featureNbr];
$tmpData = array_sort_val_key ($data, $features[$featureNbr]);
$median = $tmpData[array_count_val_key($tmpData, $features[$featureNbr])[0] / 2][$features[$featureNbr]];
$min = array_minmax_val_key("min", $data, $features[$featureNbr]);
$max = array_minmax_val_key("max", $data, $features[$featureNbr]);
$range = ($max - $min);

//print($median."   \n");
//print($min."   \n");
//print($max."   \n");
//print($range."   \n");

foreach ($data as $line) {
  if ($line[$features[$featureNbr]]) {
    switch ($line["Hogwarts House"]) {
      case "Gryffindor":
        $Gryffindor[] = $line;
        break;
      case "Hufflepuff":
        $Hufflepuff[] = $line;
        break;
      case "Ravenclaw":
        $Ravenclaw[] = $line;
        break;
      case "Slytherin":
        $Slytherin[] = $line;
        break;
    }
  }
}
$Gryffindor = array_sort_val_key ($Gryffindor, $features[$featureNbr]);
$Hufflepuff = array_sort_val_key ($Hufflepuff, $features[$featureNbr]);
$Ravenclaw = array_sort_val_key ($Ravenclaw, $features[$featureNbr]);
$Slytherin = array_sort_val_key ($Slytherin, $features[$featureNbr]);

$resultG = array_creation($Gryffindor, $features[$featureNbr], $median, $range);
$resultH = array_creation($Hufflepuff, $features[$featureNbr], $median, $range);
$resultR = array_creation($Ravenclaw, $features[$featureNbr], $median, $range);
$resultS = array_creation($Slytherin, $features[$featureNbr], $median, $range);

function array_creation ($ar, $feature, $median, $range) {
  $i = 0;
  $start = 0;
  $return = array();
  while (++$i <= 10) {
    $result = array_count_val_key($ar, $feature,(1 * $median - $range / 2) + ($i / 10) * $range, $start);
    $return[] = array("label"=> strval(number_format(((1 * $median - $range / 2) + (($i - 1) / 10) * $range), 2, '.', ''))." à ".strval(number_format(((1 * $median - $range / 2) + ($i / 10) * $range), 2, '.', '')), "y"=> $result[0]);
    $start = $result[1];
  }
  return $return;
}

$dataPoints1 = array(
  array("label"=> "2010", "y"=> 36.12),
  array("label"=> "2011", "y"=> 34.87),
  array("label"=> "2012", "y"=> 40.30),
  array("label"=> "2013", "y"=> 35.30),
  array("label"=> "2014", "y"=> 39.50),
  array("label"=> "2015", "y"=> 50.82),
  array("label"=> "2016", "y"=> 74.70)
);
?>
<!DOCTYPE HTML>
<html>
<head>
  <script type="text/javascript" src="canvasjs-3.0.5/canvasjs.min.js"></script>
  <script>
      window.onload = function () {

          var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              theme: "light2",
              title:{
                  text: "<?php echo $title; ?>",
                  fontSize: 33,
                  padding: 60
              },
              axisY:{
                  includeZero: true
              },
              legend:{
                  cursor: "pointer",
                  verticalAlign: "center",
                  horizontalAlign: "right",
                  itemclick: toggleDataSeries
              },
              data: [{
                  type: "column",
                  name: "Ravenclaw",
                  indexLabel: "{y}",
                  yValueFormatString: "#.##",
                  showInLegend: true,
                  dataPoints: <?php echo json_encode($resultR, JSON_NUMERIC_CHECK); ?>
              },{
                  type: "column",
                  name: "Slytherin",
                  indexLabel: "{y}",
                  yValueFormatString: "#.##",
                  showInLegend: true,
                  dataPoints: <?php echo json_encode($resultS, JSON_NUMERIC_CHECK); ?>
              },{
                  type: "column",
                  name: "Gryffindor",
                  indexLabel: "{y}",
                  yValueFormatString: "#.##",
                  showInLegend: true,
                  dataPoints: <?php echo json_encode($resultG, JSON_NUMERIC_CHECK); ?>
              },{
                  type: "column",
                  name: "Hufflepuff",
                  indexLabel: "{y}",
                  yValueFormatString: "#.##",
                  showInLegend: true,
                  dataPoints: <?php echo json_encode($resultH, JSON_NUMERIC_CHECK); ?>
              }]
          });
          chart.render();

          function toggleDataSeries(e){
              if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                  e.dataSeries.visible = false;
              }
              else{
                  e.dataSeries.visible = true;
              }
              chart.render();
          }

      }
  </script>
  <style>
    .nav {
      background-color: transparent;
      border-radius: 25px;
      box-shadow: 1px 1px 0 0 gray;
      color: dimgray;
      padding: 0.2em;
      position: relative;
      text-decoration: none;
      text-transform: uppercase;
      font-size: 14px;
      font-family: "Trebuchet MS", Helvetica, sans-serif;
    }

    .l1 {
      top: 8em;
      margin-right: 1em;
      left: 4%;
    }
    .l2 {
      top: 10em;
      margin-right: 1em;
      left: 35%;
    }

    .good {
      border: solid green 0.2em;
      transition: border-width 0.1s linear;
    }
    .good:hover {
      border-width: 0.4em;
    }

    .bad {
      border: solid red 0.2em;
      transition: border-width 0.1s linear;
    }
    .bad:hover {
      border-width: 0.4em;
    }

    .idk {
      border: solid dodgerblue 0.2em;
      transition: border-width 0.1s linear;
    }
    .idk:hover {
      border-width: 0.4em;
    }

    body {
      white-space: nowrap;
    }
  </style>
</head>
<body>
<div id="chartContainer" style="height: 500px; width: 100%;"></div>
<!--<div class="links">-->
<a class="nav l1 idk" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=0">Arithmancy</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=1">Astronomy</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=2">Herbology</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=3">Defense Against the Dark Arts</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=4">Divination</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=5">Muggle Studies</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=6">Ancient Runes</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=7">History of Magic</a>
<a class="nav l1 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=8">Transfiguration</a>
<a class="nav l1 idk" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=9">Potions</a>
<br/>
<a class="nav l2 good" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=10">Care of Magical Creatures</a>
<a class="nav l2 idk" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=11">Charms</a>
<a class="nav l2 bad" href="http://localhost:8000/histogram.php?csv=dataset_train.csv&feature=12">Flying</a>
</body>
</html>
