clear
#cat /var/log/syslog |less
grep CRON /var/log/syslog |less
grep /allsky /var/log/syslog |less
grep webcam /var/log/syslog |less

#journalctl -u cron.service
#journalctl -u webcam

#grep "cron.d" webcam
