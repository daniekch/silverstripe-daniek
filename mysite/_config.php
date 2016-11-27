<?php

global $project;
$project = 'mysite';

require_once("conf/ConfigureFromEnv.php");

// Set the site locale
i18n::set_locale('de_DE');
i18n::set_date_format('dd.MM.yyyy');
i18n::set_time_format('HH:mm:ss');

// Custom Login form
Object::useCustomClass('MemberLoginForm', 'CustomLoginForm');

// log errors and warnings
SS_Log::add_writer(new SS_LogFileWriter('../mysite/logs/logfile-'.date("Ymd").'.log'), SS_Log::INFO);
