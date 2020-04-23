# File concatday.sh

# Make a copy of the current movie so the user still has access and we can also work on the new one
/bin/cp /home/allsky/pics/movieday.mp4 /home/allsky/pics/temp1.mp4

# Remove any files that are too small as they were grabbed at changeover unfinished.
#/usr/bin/find . -name "/home/allsky/pics/webcam-*.jpg" -type 'f' -size -100k -delete

# Make a new movie of this last period
/usr/bin/ffmpeg -framerate 5 -pix_fmt yuv420p -pattern_type  glob -i '/home/allsky/pics/webcam-*.jpg' -c:v libx264 /home/allsky/pics/temp2.mp4

# Concatonate the two temp* movies into a new mp4
/usr/bin/ffmpeg -i /home/allsky/pics/temp1.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts /home/allsky/pics/input1.ts
/usr/bin/ffmpeg -i /home/allsky/pics/temp2.mp4 -c copy -bsf:v h264_mp4toannexb -f mpegts /home/allsky/pics/input2.ts
/usr/bin/ffmpeg -i "concat:/home/allsky/pics/input1.ts|/home/allsky/pics/input2.ts" -c copy /home/allsky/pics/temp3.mp4

# Move the new mp4 to replace the old
/bin/cp /home/allsky/pics/temp3.mp4 /home/allsky/pics/movieday.mp4
/bin/cp /home/allsky/pics/movieday.mp4 /var/www/html/movieday.mp4

# Clean up ready for necxt time
/bin/rm /home/allsky/pics/temp*.mp4
/bin/rm /home/allsky/pics/*.ts
/bin/cp /home/allsky/pics/webcam-*.jpg /home/allsky/pics/day/
/bin/rm /home/allsky/pics/webcam-*.jpg

# Done
