#!/bin/bash

files=`find /var/lib/bacula/storage/ -mtime +90 -type f`

for file in $files; do
  fname=`basename $file`
  ls -lh $file
  rm -i $file
  echo "delete volume=${fname} yes" | bconsole
done
