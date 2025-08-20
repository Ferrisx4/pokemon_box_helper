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

function print_placement($dex_no, $name) {
  $placement = get_placement($dex_no);
  
  echo "Pokemon number ";
  echo $dex_no . ", " . $name . ", ";
  echo "goes in box: ";
  echo $placement[0];
  echo ", column ";
  echo $placement[1];
  echo ", row ";
  echo $placement[2];
  echo "\n";
}


// Open the Pokédex and shove it into an assoc array.
if (($handle = fopen("dex.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 20, ",")) !== FALSE) {
    // 1,Bulbasaur
    $pokedex[(int)$data[0]] = $data[1];
    // Bulbasaur, 1 (lol)
    $pokedex[$data[1]] = (int)$data[0];
  }
}
else {
  echo "That did not work";
  exit;
}
$inputs = $argv;
// Get rid of the program name lol.
array_shift($inputs);
$misspell = 0;
foreach ($inputs as $input) {
  // If a Dex no was given.
  if (is_numeric($input)) {
    // Check for decimals, silly users...
    $original = $input;
    $input = (int)$input;
    if ($input != $original) {
      echo "Pokédex numbers are integers. Rounding " . $original . " to " . $input . "...\n";
    }
    // Check for out-of-bounds numbers:
    if ($input > 0 && $input <= 1024) {
      print_placement($input, $pokedex[$input]);
    }
    else {
      echo "There are no Pokémon that have the Pokédex Number " . $input . ".\n";
    }
  }
  // If a Pokemon name was given.
  else {
    if (!array_key_exists($input, $pokedex)) {
      $misspell = 1;
      echo $input . "? That Pokémon's name could not be found. See the note below about spelling common spelling problems.\n";
    }
    else {
      print_placement($pokedex[$input], $input);
    }
  }
}

// Print helpful message AFTER all the other Pokémon have been printed.
if ($misspell) {
  echo "Check the following:\n";
  echo " - Names are case-sensitive\n";
  echo " - Names with spaces and apostrophes need to be escaped, as such:\n";
  echo "   - Mr. Mime -> Mr.\ Mime\n";
  echo "   - Farfetch'd -> Farfetch\'d\n";
  echo " - For Nidoran♀ and Nidoran♂, you can either use these characters or F and M, respectively:\n";
  echo "   - Nidoran♀ -> Nidoran♀ OR NidoranF\n";
  echo "   - Nidoran♂ -> Nidoran♂ OR NidoranM\n";
  echo " - '-' and ':' do not have to be escaped:\n";
  echo "   - Type: Null -> Type:\ Null\n";
  echo "   - Jangmo-o -> Jangmo-o\n";
  
}

