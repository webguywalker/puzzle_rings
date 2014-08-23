<?

// Canvas
$w = 900;
$h = 400;

$gd = imagecreatetruecolor($w, $h);
imagealphablending($gd, false);
imagesavealpha($gd, true); 



$radius = 100;

$blue	= imagecolorallocate($gd, 0, 0, 255);
$yellow = imagecolorallocate($gd, 225, 225, 0);
$black	= imagecolorallocate($gd, 0, 0, 0);
$green	= imagecolorallocate($gd, 0, 255, 0); 
$red	= imagecolorallocate($gd, 255, 0, 0);
$white	= imagecolorallocate($gd, 255, 255, 255);


imagecolortransparent($gd, $white);
imagefilledrectangle($gd, 0, 0, 900, 400, $white);

// Global Ring Attributes
$rings = array(
	'total'=>5,
	'radius'=>100,
	'stroke_width'=>5,
	'padding'=>150,
	'order' => array($blue,$yellow,$black,$green,$red)
);


//$w = ($rings['total']*($rings['radius']*2))+$rings['padding'];


function draw_ring($rx, $ry, $radius, $color) {

	global $gd, $blue, $yellow, $black, $green, $red;

	$ring_center = array('x'=>$rx,'y'=>$ry);

	for ($i = 0; $i < 360; $i++) {

		if($color == $blue && $i > 57 && $i < 67) {
			continue;
		}
		if($color == $yellow && $i > 235 && $i < 245) {
			continue;
		}
		if($color == $black && (($i > 200 && $i < 210) || ($i > 57 && $i < 67)) ){
			continue;
		}
		if($color == $green && (($i > 235 && $i < 245) || ($i > 19 && $i < 29)) ){
			continue;
		}
		if($color == $red && $i > 200 && $i < 210) {
			continue;
		}

		$degrees = $i;

		for ( $e=0; $e < 20; $e++) {
			$y_from_ring_center = sin(deg2rad($degrees))*($radius + $e);
			$x_from_ring_center = cos(deg2rad($degrees))*($radius + $e);
			$x = $ring_center['x'] + $x_from_ring_center;
			$y = $ring_center['y'] + $y_from_ring_center;
			imagesetpixel($gd, round($x),round($y), $color);
		}
	}
}

$rx = 0;


for($i=1;$i<=$rings['total']; $i++) {

	$ry = $h/2;
	//echo ($i%2).'<br />';
	if( ($i%2) ) {
		$ry -= 50;
	}

	$rx = $rx + $rings['padding'];
	//$ry = $ry + $rings['padding'];
	
	//Offset by -1 because I started $i at 1
	$color = $rings['order'][$i-1];
	
	draw_ring($rx,$ry,$rings['radius'],$color);
}

header('Content-Type: image/png');
imagepng($gd);



