#!/bin/bash
# File newdaymovie.sh

#  Run a NIGHT concaenate to add any las remaining still images to the Night video
# Make a copy of the current movie so the user still has access and we can also work on the new one
cp /home/allsky/pics/movienight.mp4 /home/allsky/pics/temp1.mp4

# Make a new movie of this last period
/usr/bin/ffmpeg -framerate 5 -pix_fmt yuv420p -pattern_type  glob -i '/home/allsky/pics/webcam-*.jpg' -c:v libx264 /home/allsky/pics/temp2.mp4

# Concatonate the two temp* movies into a new mp4
/usr/bin/ffmpeg -i /home/allsky/pics/temp1.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts /home/allsky/pics/input1.ts
/usr/bin/ffmpeg -i /home/allsky/pics/temp2.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts /home/allsky/pics/input2.ts
/usr/bin/ffmpeg -i "concat:/home/allsky/pics/input1.ts|/home/allsky/pics/input2.ts" -c copy /home/allsky/pics/temp3.mp4

# Move the new mp4 to replace the old
cp /home/allsky/pics/temp3.mp4 /home/allsky/pics/movienight.mp4
cp /home/allsky/pics/movienight.mp4 /var/www/html/movienight.mp4

# Clean up ready for next time
rm /home/allsky/pics/temp*.mp4
rm /home/allsky/pics/*.ts
cp /home/allsky/pics/webcam-*.jpg /home/allsky/pics/night/
rm /home/allsky/pics/webcam-*.jpg
# Done

# Make the new Day movie
rm /home/allsky/pics/movieday.mp4

# Check to see if there are any .jpg files with which to make a new movie.  If not, get a couple.
#if ls /home/allsky/pics/webcam-*.jpg 1> /dev/null 2>&1; then
#    echo "webcam-*.jpg files do exist"> /dev/null 2>&1
#else
#    echo "files do not exist"> /dev/null 2>&1

    # Remove any files that are too small as they were grabbed at changeover that may be incomplete.
    find . -name "/home/allsky/pics/night/webcam-*.jpg" -type 'f' -size -90k -delete

    # Copy the latest two files fron night to ../pics
	cp $(ls -t /home/allsky/pics/night/* | head -2) /home/allsky/pics
#fi

# Make a new movie of this last period
/usr/bin/ffmpeg -framerate 5 -pix_fmt yuv420p -pattern_type  glob -i '/home/allsky/pics/webcam-*.jpg' -c:v libx264 /home/allsky/pics/movieday.mp4

# Put the new video where the web pages can read it
cp /home/allsky/pics/movieday.mp4 /var/www/html/movieday.mp4

# Get rid of undeeded files
rm /home/allsky/pics/day/webcam-*.jpg
