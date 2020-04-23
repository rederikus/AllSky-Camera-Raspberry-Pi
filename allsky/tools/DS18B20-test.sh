#!/bin/bash
sudo modprobe w1-gpio
sudo modprobe w1-therm
#roomtemp=$(cat /sys/bus/w1/devices/28-030997940158/w1_slave | grep  -E -o ".{0,0}t=.{0,5}" | cut -c 3-)
roomtemp=$(cat /sys/bus/w1/devices/28-*/w1_slave | grep  -E -o ".{0,0}t=.{0,5}" | cut -c 3-)
echo
perl -e "printf('Outdoor Temperature: %.1f', $roomtemp/1000)"
echo $'\xc2\xb0'C
perl -e "printf('Outdoor Temperature: %.1f', ($roomtemp/1000)*9/5+32)"
echo $'\xc2\xb0'F
echo
