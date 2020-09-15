<?php
include 'csv_to_array.php';
include 'array_minmax_val_key.php';

function ft_count_feature($array, $feature)
{
  $lineCount = 0;
  foreach ($array as $line) {
    if ($line[$feature])
    $lineCount++;
  }
  return (float)$lineCount;
}

function ft_mean_feature($array, $feature)
{
  $sum = 0;
  foreach ($array as $line) {
    if ($line[$feature]) {
      $sum += (float)$line[$feature];
    }
  }
  return ($sum / ft_count_feature($array, $feature));
}

function ft_std_feature($array, $feature)
{
  $sum = 0;
  $mean = ft_mean_feature($array, $feature);
  foreach ($array as $line) {
    if ($line[$feature]) {
      $sum += pow(((float)$line[$feature] - $mean), 2);
    }
  }
  $result = sqrt($sum / ft_count_feature($array, $feature));
  return number_format($result, 6, '.', '');
}

function ft_minmax_feature($m , $array, $feature)
{
  $minmax = array_minmax_val_key($m , $array, $feature);
  return number_format($minmax, 6, '.', '');
}

function ft_quartile_feature($Q, $array, $feature)
{
  $Q === "Q1" ? $Q = 0.25 : $Q = 0.75;
  $tmpArray = array();
  $index = $Q * ft_count_feature($array, $feature);
  if ($index - (int)$index) {
    $index += (1 - ($index - (int)$index));
  }
  foreach ($array as $line) {
    $tmpArray[] = $line[$feature];
  }
  sort($tmpArray);
  return number_format((float)$tmpArray[$index], 6, '.', '');
}

function ft_median_feature($array, $feature)
{
  $tmpArray = array();
  $index = 0.5 * (ft_count_feature($array, $feature) + 1);
  foreach ($array as $line) {
    $tmpArray[] = $line[$feature];
  }
  sort($tmpArray);
  if ($index - (int)$index) {
    $value = 0.5 * ($tmpArray[(int)$index] +$tmpArray[(int)$index + 1]);
  }
  else {
    $value = $tmpArray[(int)$index];
  }
  return number_format((float)$value, 6, '.', '');
}

function ft_variance_feature($array, $feature)
{
  $sum = 0;
  $mean = ft_mean_feature($array, $feature);
  foreach ($array as $line) {
    if ($line[$feature]) {
      $sum += pow(((float)$line[$feature] - $mean), 2);
    }
  }
  $result = $sum / ft_count_feature($array, $feature);
  return number_format($result, 6, '.', '');
}

if ((isset($argc) && $argc === 2) || $_GET["csv"]) {
  if(isset($argc) && $argc === 2) {
    $data = csv_to_array($argv[1], ',');
  }
  else {
    $data = csv_to_array($_GET["csv"], ',');
  }
  $features = array('Arithmancy', 'Astronomy', 'Herbology', 'Defense Against the Dark Arts', 'Divination', 'Muggle Studies', 'Ancient Runes', 'History of Magic', 'Transfiguration', 'Potions', 'Care of Magical Creatures', 'Charms', 'Flying');
  $mask1 = "    %-10s     %16s     %16s     %16s     %30s     %16s     %16s     %16s\n";
  $mask2 = "    %-10s     %16s     %16s     %16s     %30s     %16s     %16s\n";
  printf($mask1, '', $features[0], $features[1], $features[2], $features[3], $features[4], $features[5], $features[6]);
  printf($mask1, 'Count', number_format(ft_count_feature($data, $features[0]), 6, '.', ''), number_format(ft_count_feature($data, $features[1]), 6, '.', ''), number_format(ft_count_feature($data, $features[2]), 6, '.', ''), number_format(ft_count_feature($data, $features[3]), 6, '.', ''), number_format(ft_count_feature($data, $features[4]), 6, '.', ''), number_format(ft_count_feature($data, $features[5]), 6, '.', ''), number_format(ft_count_feature($data, $features[6]), 6, '.', ''));
  printf($mask1, 'Mean', number_format(ft_mean_feature($data, $features[0]), 6, '.', ''), number_format(ft_mean_feature($data, $features[1]), 6, '.', ''), number_format(ft_mean_feature($data, $features[2]), 6, '.', ''), number_format(ft_mean_feature($data, $features[3]), 6, '.', ''), number_format(ft_mean_feature($data, $features[4]), 6, '.', ''), number_format(ft_mean_feature($data, $features[5]), 6, '.', ''), number_format(ft_mean_feature($data, $features[6]), 6, '.', ''));
  printf($mask1, 'Std', ft_std_feature($data, $features[0]), ft_std_feature($data, $features[1]), ft_std_feature($data, $features[2]), ft_std_feature($data, $features[3]), ft_std_feature($data, $features[4]), ft_std_feature($data, $features[5]), ft_std_feature($data, $features[6]));
  printf($mask1, 'Min', ft_minmax_feature("min", $data, $features[0]), ft_minmax_feature("min", $data, $features[1]), ft_minmax_feature("min", $data, $features[2]), ft_minmax_feature("min", $data, $features[3]), ft_minmax_feature("min", $data, $features[4]), ft_minmax_feature("min", $data, $features[5]), ft_minmax_feature("min", $data, $features[6]));
  printf($mask1, '25%', ft_quartile_feature("Q1", $data, $features[0]), ft_quartile_feature("Q1", $data, $features[1]), ft_quartile_feature("Q1", $data, $features[2]), ft_quartile_feature("Q1", $data, $features[3]), ft_quartile_feature("Q1", $data, $features[4]), ft_quartile_feature("Q1", $data, $features[5]), ft_quartile_feature("Q1", $data, $features[6]));
  printf($mask1, '50%', ft_median_feature($data, $features[0]), ft_median_feature($data, $features[1]), ft_median_feature($data, $features[2]), ft_median_feature($data, $features[3]), ft_median_feature($data, $features[4]), ft_median_feature($data, $features[5]), ft_median_feature($data, $features[6]));
  printf($mask1, '75%', ft_quartile_feature("Q3", $data, $features[0]), ft_quartile_feature("Q3", $data, $features[1]), ft_quartile_feature("Q3", $data, $features[2]), ft_quartile_feature("Q3", $data, $features[3]), ft_quartile_feature("Q3", $data, $features[4]), ft_quartile_feature("Q3", $data, $features[5]), ft_quartile_feature("Q3", $data, $features[6]));
  printf($mask1, 'Max', ft_minmax_feature("max", $data, $features[0]), ft_minmax_feature("max", $data, $features[1]), ft_minmax_feature("max", $data, $features[2]), ft_minmax_feature("max", $data, $features[3]), ft_minmax_feature("max", $data, $features[4]), ft_minmax_feature("max", $data, $features[5]), ft_minmax_feature("max", $data, $features[6]));
  printf($mask1, 'Range', ft_minmax_feature("max", $data, $features[0]) - ft_minmax_feature("min", $data, $features[0]), ft_minmax_feature("max", $data, $features[1]) - ft_minmax_feature("min", $data, $features[1]), ft_minmax_feature("max", $data, $features[2]) - ft_minmax_feature("min", $data, $features[2]), ft_minmax_feature("max", $data, $features[3]) - ft_minmax_feature("min", $data, $features[3]), ft_minmax_feature("max", $data, $features[4]) - ft_minmax_feature("min", $data, $features[4]), ft_minmax_feature("max", $data, $features[5]) - ft_minmax_feature("min", $data, $features[5]), ft_minmax_feature("max", $data, $features[6]) - ft_minmax_feature("min", $data, $features[6]));
  printf($mask1, 'Variance', ft_variance_feature($data, $features[0]), ft_variance_feature($data, $features[1]), ft_variance_feature($data, $features[2]), ft_variance_feature($data, $features[3]), ft_variance_feature($data, $features[4]), ft_variance_feature($data, $features[5]), ft_variance_feature($data, $features[6]));
  printf("\n   |===========================================================================================================================================================================|\n\n");
  printf($mask2, '', $features[7], $features[8], $features[9], $features[10], $features[11], $features[12]);
  printf($mask2, 'Count', number_format(ft_count_feature($data, $features[7]), 6, '.', ''), number_format(ft_count_feature($data, $features[8]), 6, '.', ''), number_format(ft_count_feature($data, $features[9]), 6, '.', ''), number_format(ft_count_feature($data, $features[10]), 6, '.', ''), number_format(ft_count_feature($data, $features[11]), 6, '.', ''), number_format(ft_count_feature($data, $features[12]), 6, '.', ''));
  printf($mask2, 'Mean', number_format(ft_mean_feature($data, $features[7]), 6, '.', ''), number_format(ft_mean_feature($data, $features[8]), 6, '.', ''), number_format(ft_mean_feature($data, $features[9]), 6, '.', ''), number_format(ft_mean_feature($data, $features[10]), 6, '.', ''), number_format(ft_mean_feature($data, $features[11]), 6, '.', ''), number_format(ft_mean_feature($data, $features[12]), 6, '.', ''));
  printf($mask2, 'Std', ft_std_feature($data, $features[7]), ft_std_feature($data, $features[8]), ft_std_feature($data, $features[9]), ft_std_feature($data, $features[10]), ft_std_feature($data, $features[11]), ft_std_feature($data, $features[12]));
  printf($mask2, 'Min', ft_minmax_feature("min", $data, $features[7]), ft_minmax_feature("min", $data, $features[8]), ft_minmax_feature("min", $data, $features[9]), ft_minmax_feature("min", $data, $features[10]), ft_minmax_feature("min", $data, $features[11]), ft_minmax_feature("min", $data, $features[12]));
  printf($mask2, '25%', ft_quartile_feature("Q1", $data, $features[7]), ft_quartile_feature("Q1", $data, $features[8]), ft_quartile_feature("Q1", $data, $features[9]), ft_quartile_feature("Q1", $data, $features[10]), ft_quartile_feature("Q1", $data, $features[11]), ft_quartile_feature("Q1", $data, $features[12]));
  printf($mask2, '50%', ft_median_feature($data, $features[7]), ft_median_feature($data, $features[8]), ft_median_feature($data, $features[9]), ft_median_feature($data, $features[10]), ft_median_feature($data, $features[11]), ft_median_feature($data, $features[12]));
  printf($mask2, '75%', ft_quartile_feature("Q3", $data, $features[7]), ft_quartile_feature("Q3", $data, $features[8]), ft_quartile_feature("Q3", $data, $features[9]), ft_quartile_feature("Q3", $data, $features[10]), ft_quartile_feature("Q3", $data, $features[11]), ft_quartile_feature("Q3", $data, $features[12]));
  printf($mask2, 'Max', ft_minmax_feature("max", $data, $features[7]), ft_minmax_feature("max", $data, $features[8]), ft_minmax_feature("max", $data, $features[9]), ft_minmax_feature("max", $data, $features[10]), ft_minmax_feature("max", $data, $features[11]), ft_minmax_feature("max", $data, $features[12]));
  printf($mask2, 'Range', ft_minmax_feature("max", $data, $features[7]) - ft_minmax_feature("min", $data, $features[7]), ft_minmax_feature("max", $data, $features[8]) - ft_minmax_feature("min", $data, $features[8]), ft_minmax_feature("max", $data, $features[9]) - ft_minmax_feature("min", $data, $features[9]), ft_minmax_feature("max", $data, $features[10]) - ft_minmax_feature("min", $data, $features[10]), ft_minmax_feature("max", $data, $features[11]) - ft_minmax_feature("min", $data, $features[11]), ft_minmax_feature("max", $data, $features[12]) - ft_minmax_feature("min", $data, $features[12]));
  printf($mask2, 'Variance', ft_variance_feature($data, $features[7]), ft_variance_feature($data, $features[8]), ft_variance_feature($data, $features[9]), ft_variance_feature($data, $features[10]), ft_variance_feature($data, $features[11]), ft_variance_feature($data, $features[12]));
}
else {
  echo("Argument error");
}