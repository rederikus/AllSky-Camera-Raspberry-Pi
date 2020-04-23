# AllSky-Camera-Raspberry-Pi
A Raspberry Pi based Astronomy AllSky Camera
A RASPBERRY PI ALLSKY CAMERA
============================
A Raspberry Pi 3B, a Pi 8MP camera with an IMX219 sesnor and a an M12 GoPro 220 degree lens
from here https://www.aliexpress.com/item/32430326520.html?spm=a2g0s.9042311.0.0.39e04c4dEm7x8C.
A 1-Wire DS18B20 temperature sensor is included. AllSky Cam costs about $100 without a case.  
Here I used a re-purposed Clinton Electronics VX50 with the original electronics removed.

I put a buck regulator board in the case and modified the LAN cable to permit 12V DC to be fed up the 
ethernet cable so I only need one cable to the device.  You can connect via WiFi but you still
need to provide power.  I chose 12V because it is easy to derive the neccessary 5V for the Pi 
over longer distances.

The software runs under Raspian. I'm using Stretch or Buster.   I have had
a huge amount of help from the folks at the Raspberry Pi forum because I am very far from being
a programmer.  Thanks guys.

The software works by a bask shell scriot obtaining the various sunrise ans sunset times from the sunwait program.  
The numbers output from sunwait are used as the basis for writing a daily crontab file.  The crontab file then (via cron, of course)
controls what happens and when.

In use the camera takes a single 800 x 600 jpg image every 60 seconds.  Once every 3 minutes it takes 
the image to concatenate into one of two movies for day and night.  The movies run at 8 fps with the 
aim of making two daily movies of about 30 seconds each.  The device does not keep data once it has 
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

sudo apt-get upgrade
sudo apt-get dist-upgrade
sudo rpi-update # If needed.
sudo reboot

sudo raspi-config
- Enable camera
- Enable SSH and 1-Wire in Interfacing Options
SSH is to access the PI once it is in place and 1-Wire is for the DS18B20 temperature probe

Enable the DS18B20 temperat
add
w1-gpio
w1-therm
to the end of the file.

Disable the camera LED
sudo nano /boot/config.txt
add
disable_camera_led=1
dtoverlay=w1-gpio
to the end of the file.

Install lighttpd and php
sudo apt-get install lighttpd php php-cgi php-gd

Test it
sudo lighty-enable-mod fastcgi
sudo lighty-enable-mod fastcgi-php
sudo service lighttpd force-reload
echo '<?php phpinfo(); ?>' | sudo tee /var/www/phpinfo.php

Install ffmpeg = only needed if you use the Lite versions of Raspian
apt install ffmpeg

Install the software
Make a directory in /home called /home/allsky
sudo mkdir /home/allsky

Make a directory called /home/allsky/pics
sudo mkdir /home/allsky/pics
Copy the files from allsky that you downloaded to /home/allsky

sudo chmod 755 /home/allsky/sunwait/sunwait
sudo cp /home/allsky/sunwait/sunwait /usr/bin
sudo chmod 755 /etc/init.d/webcam
sudo chmod 755 /home/allsky/*.sh
sudo chmod 755 /home/allsky/pics/*.sh

copy the php and html files to /var/www/html
chmod 755 /home/allsky/sunwait/sunwait
cp /home/allsky/sunwait/sunwait /usr/bin

Get and build Sunwait if needed.  The version in the distrubution is already compiled and working.
Download sunwait from https://github.com/risacher/sunwait
Build the program via the make file - it works perfectly
Copy sunwait
cp sunwait /usr/local/bin/sunwait

reboot

Go to the Rarpberry Pi's IP address on you LAN with your browser.  It wil take up to 2 minutes 
to produce and image in daytaime and up to 4 minutes at night. 
