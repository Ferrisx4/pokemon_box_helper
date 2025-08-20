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

  // Get the column.
  $column = ($dex_no % 30) % 6;

  // Get the row.
  $row = intdiv(($dex_no % 30), 6) + 1;

  // Adjustments.
  
  if (($dex_no % 30) % 6 == 0) {
      $column += 6;
      // Detect lower right corner case.
      if ($dex_no % 30 == 0) {
        $row = 5;
      }
      else {
        $row -= 1;
      }
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

function get_pokemon_number($name) {
  if (($handle = fopen("pokedex.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 20, ",")) !== FALSE) {
      $pokedex[$data[1]] = (int)$data[0];
    }
    if (array_key_exists($name, $pokedex)) {
      return $pokedex[$name];
    }
    else {
      return NULL;
    }
  }
  else {
    echo "That did not work";
  }
}

function print_placement($dex_no) {
  $placement = get_placement($dex_no);
  
  echo "Pokemon number ";
  echo $dex_no . ", " . get_pokemon_name($dex_no) . ", ";
  echo "goes in box: ";
  echo $placement[0];
  echo ", column ";
  echo $placement[1];
  echo ", row ";
  echo $placement[2];
  echo "\n";
}

$inputs = $argv;
// Get rid of the program name lol.
array_shift($inputs);
foreach ($inputs as $input) {
  // If a Dex no was given.
  if (is_numeric($input)) {
    print_placement($input);
  }
  // If a Pokemon name was given.
  else {
    $dex_no = get_pokemon_number($input);
    if (!$dex_no) {
      echo $input . "? That Pokémon's name could not be found. Did you misspell it?\n";
      echo "Check the following:\n";
      echo " - Names are case-sensitive\n";
      echo " - Names with spaces and apostrophes need to be escaped, as such:\n";
      echo "   - Mr. Mime -> Mr.\ Mime\n";
      echo "   - Farfetch'd -> Farfetch\'d\n";
      echo " - For Nidoran♀ and Nidoran♂, you can either use these characters or F and M, respectively:\n";
      echo "   - Nidran♀ -> Nidoran♀ OR NidoranF\n";
    }
    else {
      print_placement($dex_no);
    }
  }
}

