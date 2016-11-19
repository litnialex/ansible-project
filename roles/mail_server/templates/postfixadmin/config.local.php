<?php
$CONF['database_type'] = 'mysqli';
$CONF['database_user'] = '{{ postfix_db_user }}';
$CONF['database_password'] = '{{ postfix_db_password }}';
$CONF['database_name'] = '{{ postfix_db_name }}';

$CONF['configured'] = true;

$CONF['setup_password'] = 'ec7cc2477faac2c4de9abc5e9cb8c714:54c2a1a772b8b37a72ab117963bb7b59d0881aeb';
$CONF['encrypt'] = 'cleartext';
$CONF['page_size'] = '50';
$CONF['show_password'] = 'YES';
$CONF['default_aliases'] = array ();
$CONF['domain_path'] = 'YES';
$CONF['domain_in_mailbox'] = 'NO';
$CONF['footer_text'] = 'Return to Postfix Admin';
$CONF['footer_link'] = 'http://{{ mail_server_name }}/admin';
$CONF['generate_password'] = 'YES';
$CONF['quota'] = 'YES';
$CONF['used_quotas'] = 'YES';
$CONF['aliases'] = '0';
$CONF['mailboxes'] = '0';
$CONF['maxquota'] = '0';
$CONF['domain_quota_default'] = '0';
$CONF['mailbox_postdeletion_script']='sudo /etc/postfixadmin/postfixadmin-mailbox-postdeletion.sh'
?>
