# Filename: copypic.sh
/bin/cp -a /run/shm/webcam.jpg "/home/allsky/pics/webcam-$(date +'%s').jpg"
# Remove any files that are too small as they were grabbed at changeover that may be incomplete.
cd /home/allsky/pics
/usr/bin/find . -name "webcam-*.jpg" -type 'f' -size -110k -delete
cd $HOME
# end
