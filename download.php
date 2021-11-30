<?php

if (!isset($_GET['download'])) return '';

download_file($_GET['download']);

function download_file( $url ){

  if( headers_sent() )
    die('Headers Sent');

  if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

	$url = str_replace("https://", "http://", $url);
	$fullPath = end(explode("/", $url));
	$ext = strtolower(end(explode(".", $fullPath)));

    switch ($ext) {
      case "pdf": $ctype="application/pdf"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
	    case "svg": $ctype="image/svg+xml"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      default: $ctype="application/force-download";
    }

    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"".$fullPath."\";" );
    header("Content-Transfer-Encoding: binary");
    ob_clean();
    flush();
    echo file_get_contents( $url);
}
