#!/bin/bash
logger "$0 $@"
username="$1"
domain="$2"
username=${username%@*}
if [[ -n "$username" && -n "$domain" ]]; then
  logger "$0 rm -rf /var/mail/$domain/$username"
  rm -rf "/var/mail/$domain/$username"
else
  logger "$0 doing nothing"
fi
