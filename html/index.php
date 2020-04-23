<!DOCTYPE html>
<html lang="en"><font face="verdana">
    <head>
        <meta charset="UTF-8">
        <title>AllSky Camera</title>
        <meta name="description" contents="Just a test website for learning html, css and php">
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>

<?php
// Get the Day and Night movie start & end times from /home/allsky/stimes

$myfile = fopen("/home/allsky/daily", "r") or die("Unable to open file!");
$mtimes=fread($myfile,filesize("/home/allsky/daily"));

$ADawn=substr($mtimes,0,5);
$NDawn=substr($mtimes,6,5);
$CDawn=substr($mtimes,12,5);
$SRise=substr($mtimes,18,5);
$SSet=substr($mtimes,24,5);
$CSet=substr($mtimes,30,5);
$NSet=substr($mtimes,36,5);
$ASet=substr($mtimes,42,5);
$VDay=substr($mtimes,52,5);
$VNight=substr($mtimes,58,5);

fclose($myfile);
?>
	<font color='33FF5B'><font size="6"><font face="verdana">
	<u><b>Raspberry&nbsp;&nbsp;Pi&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;AllSky&nbsp;&nbsp;Camera</b</u><br>
	</font>
        <header>
			<body style="background-color:black">
			<font color='white'><font size="6"><br>
            <nav id="main-navigation">
                <ul>
                    <li><a href="index.html"><font color='cyan'></b>A l l S k y&nbsp;&nbsp;-&nbsp;&nbsp;C a m e r a</b></font></a></li><br>
                    <li><a href="movienight.php"> <font color='cyan'>Night Sky Video&nbsp;&nbsp;<?php echo $VNight,' - ', $VDay ?></b></font></a></li><br>
		    <li><a href="movieday.php"> <font color='cyan'>Day Sky Video&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $VDay,' - ', $VNight ?></b></font></a></li><br>
                    <li><a href="suntimes.php"><font color='cyan'>Sunrise, Sunset & Twilight Times</font></a></li>
		    <font color='white'><br>
                    <li><a href="about.php"><font color='cyan'>About</u></font></a></li>
                    <font color='white'>
 </ul>
            </nav>
			</font>
			<font size="3">
        </header>
        <div id="main-contents"><font size="+2">
<?php
// Get the CPU temperature
$esc = chr(27);
$f = fopen("/sys/class/thermal/thermal_zone0/temp","r");
$CPUtemp = fgets($f);
$CPUtemp = round($CPUtemp / 1000, PHP_ROUND_HALF_UP); //round the results
fclose($f);

// Get the outside temperature
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
                 $fahrenheit = round($celsius * 9 / 5 + 32, PHP_ROUND_HALF_UP);
                 echo "Outside Temp: $celsius &deg;C / $fahrenheit &deg;F";
                 $sensors++;
             } else {
                print "No temperature read!";
             }
    }
    fclose($handle);
} else {
    print "No sensors found!";
}
?>
        </div>
        <footer>
		<font color='white'><font size="+3">
		    ________________________________________
            </font>
        </footer>
    </body>
</html>
