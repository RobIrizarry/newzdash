#!/bin/sh
# Upgrade script for Newzdash.

$NEWZDASH_PATH = "/var/www/newznab/www/newzdash"

if [ -f "$NEWZDASH_PATH" ]
then
  echo "Unable to locate $NEWZDASH_PATH, aborting"
fi

# First check if there isn't a update going on (just to be safe)
# Here for, we use a tmp file.
if [ -f /tmp/.newzdash-upgrade ]
then
  echo "Update directory already exists, are you running this twice?"
  echo "If not, then please rm -f /tmp/.newzdash-update"
  exit
fi

# There isn't running any upgrade, so create tmp file.
touch /tmp/.newzdash-upgrade
wait

echo "Requesting git repo stash and pull..."
cd $NEWZDASH_PATH
git stash
git pull

echo "Waiting for git to update the repo..."
wait

# Remove the temp file since the update is completed.
rm /tmp/.newzdash-upgrade
