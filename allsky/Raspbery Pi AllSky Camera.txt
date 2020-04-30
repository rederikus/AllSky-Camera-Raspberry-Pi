A RASPBERRY PI ALLSKY CAMERA
============================
A Raspberry Pi 3B, 4 or 0W, a Pi 8MP camera with an IMX219 sesnor and a an M12 GoPro 220 degree lens
from here https://www.aliexpress.com/item/32430326520.html?spm=a2g0s.9042311.0.0.39e04c4dEm7x8C.
A 1-Wire DS18B20 temperature sensor is included. AllSky Cam costs about $100 without a case.  
Here I used a re-purposed Clinton Electronics VX50 with the original electronics removed.

I put a buck regulator board in the case and modified the LAN cable to permit 12V DC to be fed up the 
ethernet cable so I only need one cable to the device.  You can connect via WiFi but you still
need to provide power.  I chose 12V because it is easy to derive the neccessary 5V for the Pi 
over longer distances.

However it is quite possible to use a Raspberry Pi 0W and run the whole device from a USB power supply.  
Data transfer is not supported via the USB port.

The software runs under Raspian. I'm using Stretch and Buster.  I have had a huge amount of help from the folks at the Raspberry Pi forum because I am very far from being a programmer.  Thanks guys.

In use the camera takes a single 800 x 600 jpg image every 2 minutes in daytime and 4 minutes at night.  Once every 3 minutes it takes 
the image to concatenate into one of two videos for day and night.  The videos run at 5 fps with the 
aim of making two daily videos of about 30 seconds each.  The device does not keep data once it has 
been depassed.  This means you can run the AllSky Cam from an 8GB or smaller microSD card,

The camera alone is not capable of producing usable images from all day and night ambient light levels so 
I use sunwait https://github.com/risacher/sunwait to provide daily twilight (dawn and dusk), sunrise and sunset times.  
The resultant times may be adjusted to allow exposure switching via cron to provide differing sets of 
exposure arguments to raspistill.  Sunwait needs the latitude and longitude and GMT offset to provide correct times.

The still image contains a text banner that displays, from left to right:
- The current camera mode T=Twilight, D=Day, N-Night
- The date and time the image was taken, but not neccessarily displayed.
- Today's Sunset time according to PHP's date_sunset(time().
- Current outdoor temperature from the DS18B20 in Celsius and Farenheit degrees
- Current Raspberry Pi CPU temperature in Celsius bcause the Pi COU pack it in at 85C.

A very simple menu system is provided that runs equally simply on PC and phones.  The PI has a 
lightppd webserver and may be accessed as a normal webpage.


Installation one-time tasks
---------------------------
Most of this information came from https://www.dronkert.net/rpi/webcam.html
which is what this project is based upon.

apt-get upgrade
apt-get dist-upgrade
rpi-update # If needed.
reboot

raspi-config
------------
- Enable camera
- Enable SSH and 1-Wire in Interfacing Options
SSH is to access the PI once it is in place and 1-Wire is for the DS18B20 temperature probe

Enable the DS18B20 temperature probe, if used.
----------------------------------------------
add
w1-gpio
w1-therm
to the end of the file if this has not already been done by raspi-config.


Install ffmpeg
--------------
apt install ffmpeg

Disable the camera LED
----------------------
nano /boot/config.txt
add
disable_camera_led=1
dtoverlay=w1-gpio
to the end of the file. This may have been done by raspi-config.

Install lighttpd and php
------------------------
apt-get install lighttpd php php-cgi php-gd

Test it
-------
lighty-enable-mod fastcgi
lighty-enable-mod fastcgi-php
service lighttpd force-reload
echo '<?php phpinfo(); ?>' | tee /var/www/phpinfo.php


Install the software
--------------------
Make a directory in /home called /home/allsky
mkdir /home/allsky

Make a directory called /home/allsky/pics
mkdir /home/allsky/pics

Set the file permissions
------------------------
chmod 755 /home/allsky/sunwait/sunwait
cp /home/allsky/sunwait/sunwait /usr/bin
chmod 755 /home/allsky/webcam
chmod 755 /home/allsky/pics/*.sh

Copy the php and html files to /var/www/html
--------------------------------------------
chmod 755 /home/allsky/sunwait/sunwait
cp /home/allsky/sunwait/sunwait /usr/bin

Get and build Sunwait
---------------------
Download sunwait from https://github.com/risacher/sunwait
Build the program via the make file - it works perfectly
Copy sunwait
cp /home/allsky/sunwait/sunwait /usr/local/bin/sunwait

reboot

Edit the webcam file
--------------------
nano /home/allsky/webcam     Change the variables lat and lon to reflect your staion, save and exit the file.
Run webcam with: 
/home/allsky/webcam

Webcan will now run and produce images and video automatically.
