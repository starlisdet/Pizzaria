<?php

function uploadImage ($data) {
  $target_dir = "../../frontend/assets/image/";
  $target_file = $target_dir . basename($data["image"]["name"]);
  $filePath = $target_file. rand(10000, 990000). '_'. time();
  $url = str_replace("../../frontend",".",$filePath);

  if ( move_uploaded_file( $data["image"]["tmp_name"], $filePath)) {
    return $url;
  } else {
    echo('erro ao carregar imagem');
  }
}
