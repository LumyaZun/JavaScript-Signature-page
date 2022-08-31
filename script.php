<?php
  session_start();
	define('UPLOAD_DIR', 'image/');
	$img = $_POST['imgBase64'];s
  $materielid = $_POST['materiel_id'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	//$file = UPLOAD_DIR . uniqid() . '.png';
	$file = UPLOAD_DIR  . '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';
?>