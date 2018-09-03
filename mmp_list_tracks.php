<?php

$file = file_get_contents($argv[1], NULL, NULL, 12);
$string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $file);

$cursor = 0;
for ($i=1; $i<=substr_count($file,"TRKI"); $i++){
  $fn_start = strpos($file,"TRKF",$cursor) + 5;
  $cursor = $fn_start;
  $fn_end = strpos($file,"TRSI",$cursor);
  $cursor = $fn_end;

  $in_start = strpos($file,"TRSI",$cursor) + 4;
  $cursor = $in_start;
  $in_end = strpos($file,"TRSO",$cursor);
  $cursor = $in_end;

  $out_start = strpos($file,"TRSO",$cursor) + 4;
  $cursor = $out_start;
  $out_end = strpos($file,"LIST",$cursor);
  $cursor = strpos($file,"TKLY",$cursor);

  $track = substr($file,$fn_start,$fn_end - $fn_start);
  $intro = substr($file,$in_start,$in_end - $in_start);
  $outro = substr($file,$out_start,$out_end - $out_start);

  $intro = preg_replace('/[[:cntrl:]]/','',trim($intro,'"'));
  echo "Intro ".$i.": ".$intro."\n";
  $track = preg_replace('/[[:cntrl:]]/','',$track);
  $trackpos = strrpos($track, "\\") + 1;
  $track = substr($track, $trackpos);
  echo "Track ".$i.": ".$track."\n";
}
?>
