#!/bin/bash

wiki_name=$1
target_dir={{ moinmoin_data_dir }}/export/${wiki_name}/
lock_dir=/var/lock/${wiki_name}

if ! mkdir $lock_dir ; then
  echo "Lock failed - exit" >&2
  exit 1
fi

rm -rf "${target_dir}"
moin --quiet --wiki-url=${wiki_name} export dump --target-dir=${target_dir} --username=LitniAlex 2> /dev/null
cp -a /usr/lib/python2.7/dist-packages/MoinMoin/web/static/htdocs/modern/ ${target_dir} 
rmdir $lock_dir
