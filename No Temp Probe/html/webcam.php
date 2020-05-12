<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$now = time();     // Current time on the server
clearstatcache();  // To get fresh results for all file-info functions
$cam = '/dev/shm/webcam.jpg';  // Where raspistill will save every image
$buf = '/dev/shm/buffer.jpg';  // Buffer to avoid read/write collisions, also added text
$err = '/dev/shm/error.jpg';   // Error message if reading $cam or $buf failed
// Define the C and F degree symbols
$degc = chr(176)."C";
$degf = chr(176)."F";

// ***************************************************************
// Read the state of the camera.  This can be T=twilight, D=day, N=Night
$statefile = fopen("/home/allsky/state", "r") or die("Unable to open file!");
$cstate = substr(fgets($statefile), -2);
fclose($statefile);

/*
// ***************************************************************
//  Get the outside temperature
// Comment out this section if you do not have a DS18B20 installed.
$handle = fopen("/sys/bus/w1/devices/w1_bus_master1/w1_master_slaves", "r");
if ($handle) {
    while (($sensors = fgets($handle)) !== false) {
           $sensor = "/sys/bus/w1/devices/".trim($sensors)."/w1_slave";
           $sensorhandle = fopen($sensor, "r");
             if ($sensorhandle) {
                 $thermometerReading = fread($sensorhandle, filesize($sensor));
                 fclose($sensorhandle);
                 // We want the value after the t= on the 2nd line
                 preg_match("/t=(.+)/", preg_split("/\n/", $thermometerReading)[1], $matches);
                 $celsius = round($matches[1] / 1000, PHP_ROUND_HALF_UP); //round the results
                 $fahrenheit = round($celsius*9/5+32, PHP_ROUND_HALF_UP);
                 //print "Sensor ID#: $sensors = $celsius &deg;C / $fahrenheit &deg;F<br>";
                 $sensors++;
             } else {
                print "No temperature read!";
             }
    }
    fclose($handle);
} else {
    print "No sensors found!";
}
// ***************************************************************
*/

// Get the CPU temperature
$f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
$temp = fgets($f);
$temp = round($temp / 1000, PHP_ROUND_HALF_UP); //round the results
fclose($f);
// ***************************************************************

// ***************************************************************
// Get the sunset time from the daily file
$myfile = fopen("/home/allsky/daily", "r") or die("Unable to open file!");
$mtimes=fread($myfile,filesize("/home/allsky/daily"));

//$ADawn=substr($mtimes,0,5);
//$NDawn=substr($mtimes,6,5);
//$CDawn=substr($mtimes,12,5);
//$SRise=substr($mtimes,18,5);
$SSet=substr($mtimes,24,5);
//$CSet=substr($mtimes,30,5);
//$NSet=substr($mtimes,36,5);
//$ASet=substr($mtimes,42,5);
$sunset = 'Sunset: '. $SSet;
fclose($myfile);

// ***************************************************************
// Get file modification time of the camera image
$t_cam = 0;
if (file_exists($cam))
	if (is_readable($cam))
		$t_cam = filemtime($cam);

// Get file modification time of the image buffer
$t_buf = 0;
if (file_exists($buf))
	if (is_readable($buf))
		$t_buf = filemtime($buf);

// If camera image not found or not accessible
if (!$t_cam)
	$t_cam = $now;  // For the file name time-stamp

// JPEG image headers, time-stamped file name
header('Content-Type: image/jpeg');
// header('Content-Disposition: inline; filename="webcam_' . date('Ymd_His', $t_cam) . '.jpg"');
header('Content-Disposition: inline; filename="webcam_' . date('Ymd_His') . '.jpg"');

// If the camera image is newer than the buffer and can be read
if ($t_cam > $t_buf && $im = @imagecreatefromjpeg($cam)) {

	// Save a new buffer
	$black = @imagecolorallocate($im, 0, 0, 0);
	$white = @imagecolorallocate($im, 255, 255, 255);
	$font = 4;  // Small font
//	$text = date(' D d M Y H:i:s', $t_cam)."          Outdoor Temp: $celsius$degc / $fahrenheit$degf          CPU Temp: $temp$degc";
//	$text = substr(fgets($myfile), -2) . date(' | D d M Y H:i', $t_cam)." | $sunset | Outdoor Temp: $celsius$degc / $fahrenheit$degf | CPU Temp: $temp$degc";

// With temperature sesnsor
//	$text = $cstate . date(' | D d M Y H:i', $t_cam)." | $sunset | Outdoor Temp: $celsius$degc / $fahrenheit$degf | CPU Temp: $temp$degc";
// No temperatture sesnsor
	$text = $cstate . date(' | D d M Y H:i', $t_cam)." | $sunset |CPU Temp: $temp$degc";
        @imagestring($im, $font, 2, 1, $text, $black);  // Bottom-right shadow
	@imagestring($im, $font, 1, 0, $text, $white);
	@imagejpeg($im, $buf);  // Save to disk
	@imagejpeg($im);  // Output to browser (avoid another disk read)
	@imagedestroy($im);
	exit();  // End program early
}

// We are here if camera image not newer than buffer (or both not found)
// or reading the camera image failed

// If buffer not found or not accessible
// or reading+outputting the old buffer fails
// or reading+outputting existing error image fails
if (!$t_buf || !@readfile($buf) || !@readfile($err)) {

	// Create an error image
	$width  = 800;  // Should ideally be the same size as raspistill output
	$height = 600;

	if ($im = @imagecreatetruecolor($width, $height)) {

		$white = @imagecolorallocate($im, 255, 255, 255);
		$black = @imagecolorallocate($im, 0, 0, 0);
		@imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $white);  // Background
		@imagerectangle($im, 0, 0, $width - 1, $height - 1, $black);  // Border
		$font = 3;  // Larger font
		$text = 'Read Error';  // Message
		$tw = @imagefontwidth($font) * strlen($text);  // Text width
		$th = @imagefontheight($font);
		$x = (int)round(($width - $tw) / 2);  // Top-left text position for centred text
		$y = (int)round(($height - $th) / 2);
		@imagestring($im, $font, $x, $y, $text, $black);  // Write message in image
		@imagejpeg($im, $err);  // Save to disk
		@imagejpeg($im);  // Output to browser
		@imagedestroy($im);
	}
}
echo file_get_contents("html/footer.html");

$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
	if (!empty($referer)) {
		echo "<font color='white'><font size='5'>";
		echo '<p><a href="'. $referer .'" title="Return to the previous page"style="color: #fcba03">&laquo; Back</a></p>';
	} else {
		echo "<font color='white'>";
		echo '<p><a href="'. $referer .'" title="Return to the previous page"style="color: #fcba03">&laquo; Back</a></p>';
	}

?>
