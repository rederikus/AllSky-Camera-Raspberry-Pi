#!/bin/bash
if pgrep raspistill
then
    /bin/kill $(pgrep raspistill) > /dev/null 2>&1
    echo "raspistill stopped"
else
    echo "raspistill not running"
fi
