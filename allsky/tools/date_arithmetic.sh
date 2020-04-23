echo Now
new_date=$( date -d "$dd 1 sec ago" "+%Y-%m-%d %H:%M:%S" )
echo $new_date
echo
echo Add 1 hour
date -d "$dd 1 hour" "+%Y-%m-%d %H:%M:%S"
echo
echo Add 1 minute
date -d "$dd 1 min" "+%Y-%m-%d %H:%M:%S"
echo
echo  Add 2 minute to HH:MM
date -d "$dd 2 min" "+%H:%M"
echo
echo Add 1 second
date -d "$dd 1 sec" "+%Y-%m-%d %H:%M:%S"
echo
echo subtract 1 hour
date -d "$dd 1 hour ago" "+%Y-%m-%d %H:%M:%S"
echo
echo subtract 1 minute
date -d "$dd 1 min ago" "+%Y-%m-%d %H:%M:%S"
echo
echo subtract 1 second
date -d "$dd 1 sec ago" "+%Y-%m-%d %H:%M:%S"
echo

# ************************************************
echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"

t=$(date -d "11:48:30" +%s)
t1=$(date -d " 13:13:48" +%s)
diff=$(expr $t1 - $t)
echo $diff

old=09:11
new=17:22

# ************************************************
echo "********************************************"
# feeding variables by using read and splitting with IFS
IFS=: read old_hour old_min <<< "$old"
IFS=: read hour min <<< "$new"

# convert hours to minutes
# the 10# is there to avoid errors with leading zeros
# by telling bash that we use base 10
total_old_minutes=$((10#$old_hour*60 + 10#$old_min))
total_minutes=$((10#$hour*60 + 10#$min))

echo "the difference is $((total_minutes - total_old_minutes)) minutes"


#Another solution using date (we work with hour/minutes, so the date is not important)
old=09:11
new=17:22

IFS=: read old_hour old_min <<< "$old"
IFS=: read hour min <<< "$new"

# convert the date "1970-01-01 hour:min:00" in seconds from Unix EPOCH time
sec_old=$(date -d "1970-01-01 $old_hour:$old_min:00" +%s)
sec_new=$(date -d "1970-01-01 $hour:$min:00" +%s)

echo "the difference is $(( (sec_new - sec_old) / 60)) minutes"
# ************************************************
