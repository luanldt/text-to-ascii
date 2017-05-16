<?php

/**
 * @author Leandro Silva
 * @copyright 2017 Leandro Silva (http://grafluxe.com)
 * @license MIT
 *
 * Convert text into ascii characters.
 */

$query = "basic";
$fi = "./chars/$query.php";

if (! file_exists($fi)) {
  exit("Bad path. Try using /basic instead. \n");
}

include $fi;

function convert($str) {
  global $row_count, $row_to_start_from, $letters;

  $text = str_replace(array("\n", "\r", "\x"), "", strtolower($str));
  $text_len = strlen($text);
  $row_len = $row_count + $row_to_start_from;
  $line = "";

  //convert used characters to arrays
  for ($i = 0; $i < $text_len; $i++) {
    $let = $letters[$text[$i]];

    if (! is_array($let)) {
      $letters[$text[$i]] = explode("\n", $let);
    }
  }

  //output ascii text
  for ($i = $row_to_start_from; $i < $row_len; $i++) {
    for ($j = 0; $j < $text_len; $j++) {
      $chars = $letters[$text[$j]][$i];

      if ($chars) {
        $line .= $chars;
      } else {
        exit("You're using an unsupported character: " . substr($text, 0, $j) . "[?]\n");
      }
    }

    $line .= "\n";
  }

  return $line;
}

$out = "";

$out .= convert("hi");
$out .= convert("there");

echo $out;

?>
