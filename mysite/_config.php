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
SS_Log::add_writer(new SS_LogFileWriter('../mysite/logs/debug-logfile-'.date("Ymd").'.log'), SS_Log::DEBUG);
SS_Log::add_writer(new SS_LogFileWriter('../mysite/logs/info-logfile-'.date("Ymd").'.log'), SS_Log::INFO);
SS_Log::add_writer(new SS_LogFileWriter('../mysite/logs/warn-logfile-'.date("Ymd").'.log'), SS_Log::WARN);
SS_Log::add_writer(new SS_LogFileWriter('../mysite/logs/err-logfile-'.date("Ymd").'.log'), SS_Log::ERR);
