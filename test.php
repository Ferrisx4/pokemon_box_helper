<?php

function get_pokedex() {
  if (($handle = fopen("pokedex.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 20, ",")) !== FALSE) {
      $pokedex[$data[0]] = $data[1];
    }
    print_r($pokedex);
    return $pokedex;
  }
  else {
    echo "It didn't work";
  }
}

$dex = get_pokedex();

echo $dex => 25;

