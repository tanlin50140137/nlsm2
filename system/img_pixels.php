<?php
require 'pixels.php';

$imgPath = $_REQUEST['dir'];

$width = $_REQUEST['x']==''?0:$_REQUEST['x'];
$height = $_REQUEST['y']==''?0:$_REQUEST['y'];

$img = new Imagecreate($imgPath,$width,$height);