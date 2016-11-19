#!/bin/sh
PERCENT=$1
USER=$2
cat << EOF | /usr/lib/dovecot/dovecot-lda -d $USER -o "plugin/quota=dict:Mailbox_Quota::noenforcing:proxy::sqlquota"
From: postmaster@{{ domain }}
Subject: quota warning

Your mailbox is over $PERCENT% full.

EOF
