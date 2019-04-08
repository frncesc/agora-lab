<?php
require_once('env-config.php');
require_once('dblib-mysql.php');
?>

    <!DOCTYPE html>
    <html lang="ca">
    <head>
        <meta charset="utf-8">
        <title>Check crons</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">

<?php

$hostname = getenv('HOSTNAME');
if (empty($hostname)) {
    $hostname = gethostname();
}
$services = getServices(true);
foreach ($services as $school) {

    if (!isset($moodle2) && $school['service'] == 'moodle2') {
        $moodle2 = $school;
    }
    if (!isset($nodes) && $school['service'] == 'nodes') {
        $nodes = $school;
    }
    if (isset($nodes) && isset($moodle2)) {
        break;
    }
}
$time = time();
$urlbase = $agora['server']['server'].$agora['server']['base'].'/';

echo '<h1>Check crons</h1>';
echo '<div class="well well-sm">Servidor web: ' . $hostname . ' (' .php_uname('s') . ')<br/>';
echo 'Hora del servidor: ' . date("d-m-Y H:i:s e (P)") . '</div>';

echo '<h2>Crons de tots els frontals</h2>';
echo '<h3>Cron Delete Cache Ins</h3>';
$dirname = $agora['server']['root'] . 'cache_ins';
if (!file_exists($dirname)) {
    echo_error('No existeix el cache_ins');
} else {
    $error = false;
    $dirs = scandir($dirname);
    foreach ($dirs as $dir) {
        if ($dir != '.' && $dir != '..' && is_dir($dirname.'/'.$dir)) {
            $dir = $dirname.'/'.$dir;
            $filetime = max(filectime($dir),  filemtime($dir));
            if ($time - $filetime > 86400) {
                echo '<strong>Darrera modificació:</strong> ' . date(DATE_RFC822, $filetime) . '<br>';
                echo_error('El directori '.$dir.' fa més de 24h que no s\'esborra');
                $error = true;
                break;
            }
        }
    }
    if (!$error) {
        echo 'OK';
    }
}

echo '<h3>Cron Sync (AllSchools)</h3>';
checkOldFile($agora['dbsource']['dir'] . 'allSchools.php', 86400);

echo '<h2>Crons cabina de disc</h2>';
echo '<h3>Cron Disk Usage</h3>';
checkOldFile($agora['server']['root'] . $agora['moodle2']['datadir'] . $agora['moodle2']['diskusagefile'], 86400);
checkOldFile($agora['server']['root'] . $agora['nodes']['datadir'] . $agora['nodes']['diskusagefile'], 86400);

echo '<h2>Crons del frontal principal</h2>';
echo '<h3>Cron Àgora Diari</h3>';
echo '<h4>createSchoolsListFiles</h4>';
$cronmoodle = checkOldFile($agora['server']['root'] . 'adminInfo/cronMoodle2.txt', 86400);


echo '<h4>Tar Cronlogs</h4>';
$filename = $agora['server']['root'] . 'logs/' . 'crons.'.date("Ymd", strtotime('yesterday')).'.tgz';
if (file_exists($filename)) {
    echo 'OK';
} else {
    echo_error('El fixer '.$filename.' no existeix');
}

echo '<h3>Cron Moodle2</h3>';
if ($cronmoodle) {
    if (!isset($moodle2)) {
        echo_error('No  hi ha cap moodle actiu');
    } else if (!($con = connect_moodle($moodle2))) {
        echo_error('No s\'ha pogut connectar a la base de dades de la moodle del centre ' . $moodle2['dns']);
    } else {
        $sql = 'SELECT MAX(lastruntime) as max FROM '.$agora['moodle2']['prefix'].'task_scheduled';
        $stmt = oci_parse($con, $sql);
        $lastcron = '';
        if (oci_execute($stmt, OCI_DEFAULT)) {
            if (oci_fetch($stmt)) {
                $lastcron = oci_result($stmt, 'MAX');
            }
        }
        if (empty($lastcron)) {
            $lastcron = 0;
        }

        disconnect_moodle($con);
        echo '<a href="'.$urlbase.$moodle2['dns'].'/moodle/admin/cron.php" target="_blank">'.
            $urlbase.$moodle2['dns'].'/moodle/admin/cron.php</a><br>';
        echo '<strong>Darrer cron:</strong> ' . date(DATE_RFC822, $lastcron) . '<br>';
        if ($time - $lastcron > 86400) {
            echo_error('El cron no ha estat executat en les darreres 24h');
        }
    }
}

echo '<h3>Cron Stats</h3>';
if (!($portalcon = get_dbconnection('admin'))) {
    echo_error('No s\'ha pogut connectar a la base de dades del portal');
} else {

    $dateday = date("Ymd", strtotime('yesterday'));
    $sql = 'SELECT * FROM agoraportal_moodle2_stats_day WHERE `date` = '.$dateday;
    $count = $portalcon->count_rows($sql);
    if ($count <= 0) {
        echo_error('No hi ha estadístiques del Moodle');
    } else {
        echo 'OK estadístiques Moodle<br>';
    }

    $sql = 'SELECT * FROM agoraportal_nodes_stats_day WHERE `date` = '.$dateday;
    $count = $portalcon->count_rows($sql);
    if ($count <= 0) {
        echo_error('No hi ha estadístiques del Nodes');
    } else {
        echo 'OK estadístiques Nodes<br>';
    }

    $portalcon->close();
}


echo '</div></body></html>';

function fileSizeUnits($FZ) {
    $FS = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    return number_format($FZ/pow(1024, $I=floor(log($FZ, 1024))), 2) . ' ' . $FS[$I];
}

function checkOldFile($filename, $old) {
    echo '<br><strong>Fitxer:</strong> ' . $filename . '<br>';
    if (file_exists($filename)) {
        $size = filesize($filename);
        if ($size <= 1) {
            echo_error('<strong>Mida:</strong> ' . fileSizeUnits($size));
        } else {
            echo '<strong>Mida:</strong> ' . fileSizeUnits($size) . '<br>';
        }


        $filetime = max(filectime($filename),  filemtime($filename));
        echo '<strong>Darrera modificació:</strong> ' . date(DATE_RFC822, $filetime) . '<br>';
        $time = time();
        if ($time - $filetime > $old) {
            echo_error('El fitxer és massa antic');
            return false;
        }
    } else {
        echo_error('El fitxer no existeix');
        return false;
    }
    return true;
}

function echo_error($error) {
    echo '<div class="alert-danger alert">'.$error.'</div>';
}