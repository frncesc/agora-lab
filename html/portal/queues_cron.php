<?php

define('CLI_SCRIPT', true);

// Init zikula engine
include 'lib/bootstrap.php';
$core->init();

ModUtil::load('Agoraportal', 'admin');
require_once('modules/Agoraportal/lib/Agoraportal/Util.php');


$result = Agora_Queues::execute_pending_operations();

$executeTime = date('M, d Y - H.i');

$response = '<div>' . __('Last cron execution') . ': ' . $executeTime . '</div>';
$response .= '<div>' . __('Last successful cron execution') . ':</div>';
$response .= '<div>&nbsp;</div>';
$response .= '<div>' . __('Cron results') . ': ';
if ($result) {
    $response .= '<span style="color: green;">' . __('It has been executed correctly') . '</span></div>';
} else {
    $response .= '<span style="color: orange;">' . __('It has been executed incorrectly') . '</span></div>';
}


echo $response;

System::shutdown();
