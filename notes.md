# Errors tema XTEC2:


Fitxer que no es troba:

https://moodle.loc/lib/javascript.php/1568292220/theme/xtec2/javascript/config.js

Error de javascript:

```
Uncaught ReferenceError: xtec2_theme_onload is not defined
    at upgradesettings.php:1279
    at upgradesettings.php:1301
```

Marsupial també dona problemes!
Mòdul local_rcommon: veure captura de pantalla

Revisar què passa amb:
https://moodle.loc/lib/javascript.php/1568299185/mod/hvp/library/js/h5p-event-dispatcher.js

Afecta tema XTEC2 i mòdul H5P


# Errors i warnings WordPress


Fatal error: Cannot use SimpleCalendar\Abstracts as Object because 'Object' is a special class name in /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/google-calendar-events/includes/objects.php on line 9

Warning: constant SCHOOL_CODE - assumed 'SCHOOL_CODE' (this will throw an Error in a future version of PHP) in /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php on line 72

Warning: Use of undefined constant SIMPLE_CALENDAR_MAIN_FILE - assumed 'SIMPLE_CALENDAR_MAIN_FILE' (this will throw an Error in a future version of PHP) in /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/mu-plugins/agora-functions.php on line 1433

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-includes/pluggable.php on line 1251

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-includes/pluggable.php on line 1254

Warning: call_user_func_array() expects parameter 1 to be a valid callback, function 'ass_install_emails' not found or invalid function name in /home/fbusquet/dev/agora-lab/nodes/wp-includes/class-wp-hook.php on line 286

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-admin/includes/misc.php on line 1198

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-includes/option.php on line 947

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-includes/option.php on line 948

Desactivat `google-calendar-events`


----------- Segon intent:

Warning: Use of undefined constant SCHOOL_CODE - assumed 'SCHOOL_CODE' (this will throw an Error in a future version of PHP) in /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php on line 72

Warning: Use of undefined constant SIMPLE_CALENDAR_MAIN_FILE - assumed 'SIMPLE_CALENDAR_MAIN_FILE' (this will throw an Error in a future version of PHP) in /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/mu-plugins/agora-functions.php on line 1433

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-admin/includes/misc.php on line 1198

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-includes/pluggable.php on line 1251

Warning: Cannot modify header information - headers already sent by (output started at /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/enllacos-educatius/enllacos-educatius.php:72) in /home/fbusquet/dev/agora-lab/nodes/wp-includes/pluggable.php on line 1254

Fatal error: Class 'BPGES_Async_Request' not found in /home/fbusquet/dev/agora-lab/html/wordpress/wp-content/plugins/buddypress-group-email-subscription/classes/class-bpges-async-request-subscription-migrate.php on line 6

--- Descativat `buddypress-group-email-subscription`




