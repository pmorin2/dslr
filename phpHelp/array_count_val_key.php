<?php
function array_count_val_key ($ar, $key,  $limitVal = false, $start = 0) {
  $count = 0;
  $start--;
  while (isset($ar[++$start]) && ($limitVal === false || !isset($ar[$start][$key]) || $ar[$start][$key] <= $limitVal)) {
    if (isset($ar[$start][$key]))
      $count++;
  }
  return array($count, $start);
}