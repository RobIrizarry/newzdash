#!/bin/bash
# Upgrade script for Newzdash.

NEWZDASH_PATH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

if [ -z "${NEWZDASH_PATH}" ] || [ ! -d "${NEWZDASH_PATH}" ]; then
  echo "Unable to locate NEWZDASH_PATH, aborting"
  echo "Usage: $0 /var/www/newzdash"
  exit 0
fi

# check if there isn't a update going on (just to be safe)
if [ -f "${NEWZDASH_PATH}/.upgrading" ]; then

  echo "Update directory already exists, are you running this twice?"
  echo "If not, then please rm -f ${NEWZDASH_PATH}/.upgrading"
  exit

else

  # There isn't running any upgrade, so create tmp file.
  touch "${NEWZDASH_PATH}/.upgrading"

  echo "Requesting git repo stash and pull..."
  cd "${NEWZDASH_PATH}"
  git stash
  git pull

  # Remove the temp file since the update is completed.
  rm "${NEWZDASH_PATH}/.upgrading"

fi
