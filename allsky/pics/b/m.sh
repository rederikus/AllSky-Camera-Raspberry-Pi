/bin/rm movie.mp4
/usr/bin/ffmpeg -framerate 8 -pix_fmt yuv420p -pattern_type  glob -i '*.jpg' -c:v libx264 movie.mp4


