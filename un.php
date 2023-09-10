<?php 

$zip = new ZipArchive;
$res = $zip->open('4july.zip');
if ($res === TRUE) {
  $zip->extractTo('/myzips/extract_path/');
  $zip->close();
  echo 'woot!';
} else {
  echo 'doh!';
}

?>