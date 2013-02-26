#!/bin/sh
# Upgrade script for Newzdash.
#
# First check if there isn't a update going on (just to be safe)
# Here for, we use a tmp file.
if [ -f /tmp/.newzdash-upgrade ]
then
echo "There is already an update going on, so exit."
exit
fi
# There isn't running any upgrade, so create tmp file.
touch /tmp/.newzdash-upgrade
wait
echo "Do the git pull (first cd in to the right path, edit to match yours!)."
cd /var/www/newznab/www/newzdash
git pull
echo "Wait until the pull is complete"
wait
# Remove the temp file since the update is completed.
rm /tmp/.newzdash-upgrade
