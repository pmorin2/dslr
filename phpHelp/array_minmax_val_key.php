<?php
function array_minmax_val_key($m , $array, $feature)
{

  $minmax = NULL;
  foreach ($array as $line) {
    if ($line[$feature]) {
      if ($minmax === NULL) {
        $minmax = (float)$line[$feature];
      }
      elseif(($m === "min" && (float)$line[$feature] < $minmax) || ($m === "max" && (float)$line[$feature] > $minmax)) {
        $minmax = (float)$line[$feature];
      }
    }
  }
  return $minmax;
}
