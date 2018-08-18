//{{ ansible_managed }}
<?php
$config['db_dsnw'] = 'mysql://{{ roundcube_db_user }}:{{ roundcube_db_password }}@localhost/{{ roundcube_db_name }}';
$config['default_host'] = 'localhost';
$config['smtp_server'] = 'localhost';
$config['support_url'] = '';
$config['skin_logo'] = '';
$config['des_key'] = '{{ lookup("password", "{{ roundcube_des_key_path }} length=24" ) }}';
$config['spellcheck_engine'] = 'pspell';
$config['smtp_log'] = true;
$config['smtp_debug'] = false;
$config['log_logins'] = true;
$config['log_session'] = true;
$config['imap_debug'] = false;
$config['reply_mode'] = 1;
$config['language'] = '{{ roundcube_language }}';
$config['plugins'] = array('subscriptions_option','managesieve','additional_message_headers');
$config['use_subscriptions'] = false;

$config['log_driver'] = 'syslog';
$config['syslog_facility'] = LOG_MAIL;
//$config['debug_level'] = 4;

$config['managesieve_default'] = '/etc/dovecot/sieve/default.sieve';
$config['session_lifetime'] = 30;
?>
