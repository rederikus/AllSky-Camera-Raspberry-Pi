<?php
// ***************************************************************
// Get the local gps coordinates
$gpsfile = fopen("/home/allsky/gps", "r") or die("Unable to open file!");
$gps=fread($gpsfile,filesize("/home/allsky/gps"));
$lat=substr($gps,0,6);
$lon=substr($gps,7,6);
fclose($gpsfile);
// ***************************************************************

echo '<body style="background-color:black"><font size="+3">';
echo '<font face="Roboto Mono">';
echo '<font face="verdana">';
echo "<font color='33FF5B'><u>Sun Times - Camera & Video Modes</font></u><br>";
echo "<font size='0'><br><font size='+2'><font color='94bceb'><i>" . date('D d M Y') . "</b></font><font color='gray'><font size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GPS: $lat, $lon </font></i><br>";
echo "<header('Content-Type: text/plain')>";
echo '<font color="white">';

// ***************************************************************
// Get the various daily times
$myfile = fopen("/home/allsky/daily", "r") or die("Unable to open file!");
$mtimes=fread($myfile,filesize("/home/allsky/daily"));
echo "<font color='white'>";
echo '<body style="background-color:black">';

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

$VidAM=substr($mtimes,58,5);
$VidPM=substr($mtimes,58,5);
$CamAM=substr($mtimes,64,5);
$CamPM=substr($mtimes,70,5);

echo '<table>
<table style="width:100%; border: 1px solid black">
    <tbody>
        <tr>
            <td align="left"><font color="a9f0a5"><font size="5"><b><u>Sun Position</u></b></font></td>
            <td><font color="a9f0a5"><font size="5"><b><u>Angle</font></u></b></td>
            <td><font color="a9f0a5"><font size="5"><b><u>Mode</font></u></b></td>
            <td><font color="a9f0a5"><font size="5"><b><u>HH:MM</font></u></b></td>
        </tr>
        <tr>
            <td align="left"><font color="white"><font size="6">Astronomical Dawn</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;-18&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="067cbd"><font size="6">'.$ADawn.'</font></td>
        </tr>

        <tr>
            <td align="left"><font color="white"><font size="6">Nautical Dawn</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;-12&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="11a2f0"><font size="6">'.$NDawn.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="f78fef"><font size="6">Camera mode: Day</font></td>
            <td><font color="a39f9e"><font size="6"></font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;D</font></td>
            <td><font color="f78fef""><font size="6">'.$CamAM.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="f78fef"><font size="6">Day Video start</font></td>
            <td></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;D</font></td>
            <td><font color="f78fef"><font size="6">'.$VDay.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="white"><font size="6">Civil Dawn</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;-06&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;D</font></td>
            <td><font color="84cdf5"><font size="6">'.$CDawn.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="f0f70f"><font size="6">Sunrise</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;&nbsp;0&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;D</font></td>
            <td><font color="f0f70f"><font size="6">'.$SRise.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="f0f70f"><font size="6">Sunset</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;&nbsp;0&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;D</font></td>
            <td><font color="f0f70f"><font size="6">'.$SSet.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="white"><font size="6">Civil Set</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;-06&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="84cdf5"><font size="6">'.$CSet.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="f78fef"><font size="6">Camera mode: Night</font></td>
            <td><font color="a39f9e"><font size="6"></font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="f78fef""><font size="6">'.$CamPM.'</font></td>
        </tr>
		<tr>
            <td align="left"><font color="f78fef"><font size="6">Night Video start</font></td>
            <td></font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="f78fef"><font size="6">'.$VNight.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="white"><font size="6">Nautical Set</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;-12&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="11a2f0"><font size="6">'.$NSet.'</font></td>
        </tr>
        <tr>
            <td align="left"><font color="white"><font size="6">Astronomical Set</font></td>
            <td><font color="a39f9e"><font size="6">&nbsp;-18&#176;</font></td>
            <td><font color="f78fef"><font size="4">&nbsp;&nbsp;&nbsp;N</font></td>
            <td><font color="067cbd"><font size="6">'.$ASet.'</font></td>
        </tr>

     </tbody>
</font>
</table>
</font>';

fclose($myfile);
echo '<font color="f78fef"><font size="3">Camera Mode: N=Night, D=Day</font><br>';

// ***************************************************************

echo '<a href="https://www.timeanddate.com/sun/usa/charlotte/"  style="color: #fcba03" target="_blank">True Sun Times</a>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<a href="https://www.astrospheric.com/" style="color: #fcba03" target="_blank">Astronomer&apos;s Weather</a><br>';
echo '<body style="background-color:black"><a href="https://cdn.star.nesdis.noaa.gov//GOES16/ABI/SECTOR/EUS/GEOCOLOR/GOES16-EUS-GEOCOLOR-1000x1000.gif" style="color: #fcba03" target="_blank">NOAA VIS Image</a>&nbsp;&nbsp;';
echo '<body style="background-color:black"><a href="https://cdn.star.nesdis.noaa.gov//GOES16/ABI/SECTOR/EUS/13/GOES16-EUS-13-1000x1000.gif" style="color: #fcba03" target="_blank">NOAA IR Image</a><br>';

echo"<font color='white'>____________________________________________</font><br>";

echo file_get_contents("html/footer.html");
$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
        if (!empty($referer)) {
                echo '<font size="+5">';
                echo '<a href="'. $referer .'" title="Return to the previous page"style="color: #fcba03">&laquo; Back</font></a>';
        } else {
                echo '<a href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Back</font></a>';
        }
?>
