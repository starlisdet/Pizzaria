<?php

function treat ($data) {
  $value = str_replace("R$","",$data);
  $value = str_replace(",",".",$value);
  $value = str_replace(" ","",$value);
  $value = (double)$value;
  return $value;
}