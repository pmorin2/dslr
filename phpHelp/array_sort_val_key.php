<?php
function array_sort_val_key ($ar, $key) {
  $check = true;
  while ($check){
    $check = false;
    $i = 0;
    while (isset($ar[++$i])) {
      if ($ar[$i][$key] < $ar[$i - 1][$key]) {
        $tmp = $ar[$i];
        $ar[$i] = $ar[$i - 1];
        $ar[$i - 1] = $ar[$i];
        $check = true;
      }
    }
  }
  return $ar;
}