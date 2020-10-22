<?php

$folderPath = 'upload/';

$targ_w = $targ_h = 150;
$jpeg_quality = 90;

$src = 'images/pool.jpg';
$img_r = imagecreatefromjpeg($src);
$dst_r = ImageCreateTrueColor($targ_w, $targ_h);

imagecopyresampled(
  $dst_r,
  $img_r,
  0,
  0,
  $_POST['x1'],
  $_POST['y1'],
  $targ_w,
  $targ_h,
  $_POST['w'],
  $_POST['h']
);


$file = $folderPath . uniqid() . '.jpg';

$con = mysqli_connect("localhost", "root", "", "db_login") or die("Falha ao conectar o banco");

$insert = mysqli_query($con, "insert into db_login.tbl_imagem (imagem) values ('$file')") or die(mysqli_error($con));

if ($insert) {
  echo "Cadastrado com Sucesso";

  //header('Content-type: image/jpeg');
  imagejpeg($dst_r, $file, $jpeg_quality);
} else {
  echo "Erro ao cadastrar";
}
