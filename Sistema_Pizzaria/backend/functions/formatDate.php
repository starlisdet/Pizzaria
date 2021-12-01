<?php

function formatedDate ($date) {
  $input = $date;
  $newDate = strtotime($input);
  return date('d/m/Y', $newDate);
}

function formatedHours ($date) {
  $input = $date;
  $newDate = strtotime($input);
  return date('h:i:s', $newDate);
}
