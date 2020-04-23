<?php
echo file_get_contents("html/header.html");

echo '<body style="background-color:black"><font size="6"><font face="verdana">';
echo "<font color='33FF5B'><u>Raspberry Pi AllSky Camera v1.06</u><font size='2'><br>";
echo "<font color='white'><br></font>";
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
				 echo '<font size="3"><font color="white">';
                 print "Temperature: $celsius &deg;C / $fahrenheit &deg;F | reading optimized for night.<br>";
                 $sensors++;
             } else {
                print "No temperature read!";
             }
    }
    fclose($handle);
} else {
    print "No sensors found!";
}

$myfile = fopen("/home/allsky/daily", "r") or die("Unable to open file!");
$mtimes=fread($myfile,filesize("/home/allsky/daily"));
echo "<font color='white'>";
echo '<body style="background-color:black"><font size="+3">';

$ADawn=substr($mtimes,0,5);
$NDawn=substr($mtimes,6,5);
$CDawn=substr($mtimes,12,5);
$SRise=substr($mtimes,18,5);
$SSet=substr($mtimes,24,5);
$CSet=substr($mtimes,30,5);
$NSet=substr($mtimes,36,5);
$ASet=substr($mtimes,42,5);
$DShot=substr($mtimes,48,1);
$NShot=substr($mtimes,50,1);
$VDay=substr($mtimes,52,5);
$VNight=substr($mtimes,58,5);
$Concat=substr($mtimes,76,2);
//$Concat=10;
fclose($myfile);

echo "<font size='5'><font color='yellow'>";
echo "- Camera takes an image every <font color='white'>$DShot<font color='yellow'>  minutes<br>in daytime and <font color='white'>$NShot<font color='yellow'>  minutes at night time.  <br>It does not keep history.<font size='0'><br>";
echo "<br></font>";
echo "- Night video runs from <font color='white'>$VNight<font color='yellow'> to <font color='white'>$VDay<font color='yellow'>.<br>";
echo "- Day video runs from <font color='white'>$VDay<font color='yellow'> to <font color='white'>$VNight<font color='yellow'>.<font size='0'><br>";
echo "<br></font>";
echo "- Videos updated every <font color='white'>$Concat<font color='yellow'> minutes,<br>discarded at end of next day / night.<br>";
echo "<font size='0'><br></font>";
echo "- Camera Mode: <font color='b3b5b4'>D</font><font color='yellow'>=Day, </font><font color='b3b5b4'>N</font><font color='yellow'>=Night<br>shown in image top left.<font size='0'><br>";
echo "<br></font>";
echo "- Camera Mode timing is adjustable<br>and may differ from time shown in-image.<font size='0'><br>";
echo "</font><font color='white'>";
echo '<font size="+3">';
echo"<font color='white'>____________________________________________</font><br>";
echo '<font size="3"><font color="white">'. 'email: <a href="mailto:pete.ingram@gmail.com">pete.ingram@gmail.com</font></a><br>';

$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

	if (!empty($referer)) {
		echo "<font color='white'><font size='+6'>";
		echo '<p><a href="'. $referer .'" title="Return to the previous page"style="color: #fcba03">&laquo; Back</a></p>';
	} else {
		echo "<font color='white'><font size='+6'>";
		echo '<p><a href="'. $referer .'" title="Return to the previous page"style="color: #fcba03">&laquo; Back</a></p>';
	}
?>
