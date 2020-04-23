
#!/bin/bash
BIN="raspistill" # Name of camera control executable
EXE="/usr/bin/$BIN" # Directory of camera control executable
SCR="webcam"   # script / service name

if pgrep raspistill
then
    kill $(pgrep raspistill) > /dev/null 2>&1
    echo "raspistill stopped"
else
    echo "raspistill not running"
fi

echo -n 'N'>/home/allsky/state
# The line below is just about he maximum that can be got out of araspi-cam 2 with an IMX219 sensor.
#ARG="-ISO auto -hf -awb greyworld -n -ex off -ag 8.0 -ss 8000000 -w 800 -h 600 -o /run/shm/$SCR.jpg"
#ARG="-ISO auto -hf -awb greyworld -n -ex off -ag 8.0 -w 800 -h 600 -o /run/shm/$SCR.jpg"
ARG="-ISO auto -hf -awb greyworld -n -ex off -ag 8.0 -w 800 -h 600 -o /home/allsky/tools/webcam.jpg"

d1=$(date +%s)
/usr/bin/raspistill $ARG
d2=$(date +%s)
echo Took $((d2-d1)) seconds

date
ls -l /run/shm/webcam.jpg

if [ "/run/shm/webcam.jpg" -ot "/home/allsky/tools/webcam.jpg" ]; then
    killall -9 raspistill
    cp -f "/home/allsky/tools/webcam.jpg" "/run/shm/webcam.jpg"
fi
ls -l /run/shm/webcam.jpg


#echo -e "\033[31;1mPress\e[38;5;226m <Enter>\e[31;1m to continue\e[m"


