#!/bin/bash
# raspistill time fill in still image grabs.
amtMVid=55
amtHVid=4
concat=10
Daytime="It's really dark."
EXE=123/

 echo "# DAY TIME fill in raspistill image grab AFTER $((amtH+1)) AM until hour as needed.">>$HOME/webcamcron
# Strip leading zero
amtMVidFN=$(echo $amtMVid | sed 's/^0*//')
for (( d = 0 ; d <=$amtMVidFN ; d = d + $concat )); do
  if [[ "$d" -lt $concat ]]; then
    continue
  fi
  if [[ "$d" -lt 60 ]]; then
     echo "$d $amtMHVid * * * $EXE XXX $Daytime"
  else
     echo "0 $((amtH+1)) * * * $EXE YYY $Daytime"
  fi
done

