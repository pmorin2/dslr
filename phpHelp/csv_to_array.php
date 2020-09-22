<?php
function csv_to_array($filename='', $delimiter=',')
{
  if(!file_exists($filename) || !is_readable($filename))
    return FALSE;

  $data = array();
  $header = NULL;
  if (($data = file_get_contents($filename)) !== FALSE) {
    if (($data = str_getcsv($data, "\n")) !== FALSE) {
      foreach($data as &$line) {

        if(!$header) {
          $header = str_getcsv($line, $delimiter);
        }
        else
          $line = array_combine($header, str_getcsv($line, $delimiter));
      }
    }
  }
  if(isset($data[0]))
    unset($data[0]);
  $data = (array_values($data));
//  print_r($data);
//  print_r($header);
  return $data;
}