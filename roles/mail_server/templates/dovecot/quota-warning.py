#!/usr/bin/python
# -*- coding: utf-8 -*-

from email.mime.text import MIMEText
import sys,subprocess

usage_percent = sys.argv[1]
user = sys.argv[2]
cmd=['/usr/lib/dovecot/dovecot-lda', '-d', user, '-o', 'plugin/quota=dict:Mailbox_Quota::noenforcing:proxy::sqlquota']
text = u"""Это автоматическое уведомление о том, что ваш почтовый ящик заполнен более чем на %s%%.

При заполнении почтового ящика на 100%% вы не будете получать новые письма.

Вы можете удалить старые и ненужные письма, очистить корзину для освобождения свободного места.
""" % usage_percent

msg = MIMEText(text,_charset='utf-8')
msg['Subject'] = u'Внимание: свободное место на вашей почте заканчивается!'
msg['From'] = 'postmaster@{{ domain }}'
msg['To'] = user
mime_message = msg.as_string()

p = subprocess.Popen(cmd, stdin=subprocess.PIPE, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
out, error = p.communicate(mime_message)

print out
print error
