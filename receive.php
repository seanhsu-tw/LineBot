<?php
  $json_str=file_get_contexts('php://input');
  $json_obj=json_decode($json_str);
  $my_file=fopen("log.txt","w+") or die("unable to open file!");
  fwrite($my_file,"\xEF\xBB\xBF".$json_str);
  fclose($my_file);
?>
