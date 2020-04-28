#!/bin/bash

sudo -u asterisk /usr/sbin/asterisk -rx 'pri show span 1'  |
  grep 'Status' |
  { read status state1 state2
    if [[ $state1 == "Up," && $state2 == "Active" ]]; then
      echo "OK $status $state1 $state2"
      exit 0
    else
      echo "CRITICAL $status $state1 $state2"
      exit 2
    fi
  }
