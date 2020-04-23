# File movie
/usr/bin/ffmpeg -framerate 5 -pix_fmt yuv420p -pattern_type  glob -i 'webcam-*.jpg' -c:v libx264 /home/allsky/pics/day/movie.mp4

# Done
