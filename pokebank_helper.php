<?php

function get_placement($dex_no) {
  // Get the box name ($begin - $end).
  $box_no = intdiv($dex_no, 30);
  if ($dex_no % 30 != 0) {
      $box_no = $box_no + 1;
  }

  $box_end = $box_no * 30;
  $box_begin = $box_end - 29;
  $box_name = '(' . $box_begin . ' - ' . $box_end . ')';

  // Get the column and row.
  $column = ($dex_no%30) % 6;

  $row = intdiv(($dex_no % 30), 6) + 1;

  // Adjustments.
  if (($dex_no%30) % 6 == 0) {
      $column += 6;
      $row -= 1;
  }

  return [$box_name, $column, $row];
}

function get_pokemon_name($dex_no) {
  if (($handle = fopen("pokedex.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 20, ",")) !== FALSE) {
      $pokedex[(int)$data[0]] = $data[1];
    }
    // print_r($pokedex);
    return $pokedex[$dex_no];
  }
  else {
    echo "It didn't work";
  }
}


$dex_no = $argv[1];
// If a Dex no was given.
if (is_numeric($argv[1])) {
  
}
// If a Pokemon name was given.
else {
  
}

$placement = get_placement($dex_no);

echo "Pokemon number ";
echo $dex_no . ", " . get_pokemon_name($dex_no) . ", ";
echo " goes in box: ";
echo $placement[0];
echo ", column ";
echo $placement[1];
echo ", row ";
echo $placement[2];
echo "\n";
