#!/bin/bash
# File newdaymovie.sh

# Remove any files that are too small as they were grabbed at changeover and may be incomplete.
/usr/bin/find . -wholename "/home/allsky/pics/webcam-*.jpg" -type 'f' -size -110k -delete

# Check the essential presence of raspistill webcam-*.jpg file(s).  If none, wait for one to be created.
while [ ! -f /home/allsky/pics/webcam-*.jpg  ]; do sleep 1; done
sleep 5

# Run a NIGHT concatonate to add any last remaining still images to the Night video.
# This means that the last few still image(s) of the night Nideo will be at the start of the Day video.
#
# Make a copy of the current movie so the user still has access and we can also work on the new one.
/bin/cp /home/allsky/pics/movienight.mp4 /home/allsky/pics/temp1.mp4

# Make a new movie of this last period
/usr/bin/ffmpeg -framerate 5 -pix_fmt yuv420p -pattern_type  glob -i '/home/allsky/pics/webcam-*.jpg' -c:v libx264 /home/allsky/pics/temp2.mp4

# Concatonate the two temp* movies into a new mp4
/usr/bin/ffmpeg -i /home/allsky/pics/temp1.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts /home/allsky/pics/input1.ts
/usr/bin/ffmpeg -i /home/allsky/pics/temp2.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts /home/allsky/pics/input2.ts
/usr/bin/ffmpeg -i "concat:/home/allsky/pics/input1.ts|/home/allsky/pics/input2.ts" -c copy /home/allsky/pics/temp3.mp4

# Move the new mp4 to replace the old.
/bin/cp /home/allsky/pics/temp3.mp4 /home/allsky/pics/movienight.mp4
/bin/cp /home/allsky/pics/movienight.mp4 /var/www/html/movienight.mp4

# Clean up ready for next time.
/bin/rm /home/allsky/pics/temp*.mp4
/bin/rm /home/allsky/pics/*.ts
/bin/cp /home/allsky/pics/webcam-*.jpg /home/allsky/pics/night/
/bin/rm /home/allsky/pics/webcam-*.jpg

# Check the essential presence of raspistill webcam-*.jpg file(s).  If none, wait for one to be created.
while [ ! -f /home/allsky/pics/webcam-*.jpg  ]; do sleep 1; done
/bin/sleep 5

# Make the new Day movie.
# Remove yesterday's Day movie.
/bin/rm /home/allsky/pics/movieday.mp4

# Make a new movie of this last period.
/usr/bin/ffmpeg -framerate 5 -pix_fmt yuv420p -pattern_type  glob -i '/home/allsky/pics/webcam-*.jpg' -c:v libx264 /home/allsky/pics/movieday.mp4

# Put the new video where the web pages can read it.
/bin/cp /home/allsky/pics/movieday.mp4 /var/www/html/movieday.mp4

# Get rid of uneeded files.
/bin/rm /home/allsky/pics/day/webcam-*.jpg
