#!/bin/bash

if pgrep raspistill
then
    kill $(pgrep raspistill) > /dev/null 2>&1
    echo "raspistill stopped"
else
    echo "raspistill not running"
fi

echo -n 'D'>/home/allsky/state
ARG="-ISO 80 -hf -awb greyworld -n -ex auto -w 800 -h 600 -tl 120000 -t 2147483647 -o /run/shm/$SCR.jpg"

/usr/bin/raspistill $ARG &


#echo -e "\033[31;1mPress\e[38;5;226m <Enter>\e[31;1m to continue\e[m"


