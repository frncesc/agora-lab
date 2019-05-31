<?php

/**
 * Class Service_moodle2
 * Describes a Moodle2 Service
 */
class Service_moodle2 extends Service {

    const NUM_DB_PER_INSTANCE = 200;

    /**
     * Performs the actions to replace DNS in database
     * @param $oldDNS
     * @param $newDNS
     * @return Agora_Queues_Operation|false
     */
    public function replaceDNS($oldDNS, $newDNS) {
        global $agora;

        $urlbase = $agora['server']['server'] . $agora['server']['base'];
        $urlbase = str_replace('http://', '://', $urlbase);
        $urlbase = str_replace('https://', '://', $urlbase);

        $params = array();
        $params['origintext'] = $urlbase . $oldDNS . '/moodle';
        $params['targettext'] = $urlbase . $newDNS . '/moodle';

        return Agora_Queues_Operation::add('script_replace_database_text', $this->clientId, $this->serviceId, $params, 0);
    }

    /**
     * Calculates the activedId and serviceDB free
     * @return int activedId
     */
    protected function getDBId() {
        $this->activedId = $this->calcFreeDatabase();

        if (empty($this->serviceDB)) {
            $this->serviceDB = $this->calcOracleInstance(); // calcOracleInstance() needs $this->activedId to be populated
        }

        if (empty($this->serviceDB)) {
            return LogUtil::registerError('No s\'ha pogut calcular la instància de base de dades.');
        }

        return $this->activedId;
    }

    /**
     * Calculate Oracle database instance for Moodle
     *
     * @author  Toni Ginard
     * @param   int database number
     * @return  string instance name
     */
    private function calcOracleInstance() {
        global $agora;

        $dbNumber = (int) $agora['moodle2']['dbnumber'];

        // If $dbNumber is not set or it is an empty string, no offset is applied to $agora['moodle2']['database']
        if (empty($dbNumber)) {
            return $agora['moodle2']['database'];
        }

        // Users are distributed in blocks of NUM_DB_PER_INSTANCE schemas per instance
        $DBId = $this->activedId;
        $offset = floor($DBId / self::NUM_DB_PER_INSTANCE) + (($DBId % self::NUM_DB_PER_INSTANCE) == 0 ? ($dbNumber - 1) : $dbNumber);
        if ($offset <= 0) {
            return $agora['moodle2']['database'];
        }

        return $agora['moodle2']['database'] . $offset;
    }

    /**
     * Execute the operation to correctly enable the service
     * @param $password for admin
     * @return bool
     */
    protected function enable_service($password) {
        // Generate a password for Moodle admin user
        $params = array();
        $params['password'] = md5($password);

        $client = $this->get_client();
        $params['clientName'] = $client->clientName;
        $params['clientCode'] = $client->clientCode;
        $params['clientAddress'] = $client->clientAddress;
        $params['clientCity'] = $client->clientCity;
        $params['clientDNS'] = $client->clientDNS;

        $operation = $this->addOperation('script_enable_service', $params, 5);
        if (!$operation) {
            return LogUtil::registerError('No s\'ha pogut afegir la operació d\'activació del servei');
        }
        SessionUtil::setVar('execOper', $operation->id);

        LogUtil::registerStatus('S\'està activant el servei... si no s\'activa aneu a les cues');
        return true;
    }

    /**
     * Connects to moodle database and returns the connection
     * @param $db
     * @param $userid
     * @param bool|false $createDB
     * @return resource
     * @throws Exception
     */
    public static function getDBConnection($dbHost, $db, $userid, $createDB = false) {
        global $ZConfig, $agora;
        $user = $agora['moodle2']['userprefix'] . $userid;
        $driver = 'oci8';

        if ($ZConfig['System']['oci_pconnect']) {
            $dbh = new PDO("$driver:host=$dbHost;dbname=$db", $user, $agora['moodle2']['userpwd'],array(PDO::ATTR_PERSISTENT => true));
        } else {
            $dbh = new PDO("$driver:host=$dbHost;dbname=$db", $user, $agora['moodle2']['userpwd']);
        }

        $connect = Doctrine_Manager::connection($dbh, $db);
        $connect->setOption('username',$user);
        $connect->setOption('password', $agora['moodle2']['userpwd']);

        if (!$connect) {
            $e = $connect->errorInfo();
            throw new Exception(htmlentities($e[2] . " - $user - $db"));
        }
        return $connect;
    }

    /**
     * Executes a SQL into oracle database and return the results
     * @param $sql
     * @param bool|false $connect
     * @param bool|false $keepalive
     * @return array|bool
     * @throws Exception
     */
    public static function sql($sql, $connect = false, $keepalive = false) {
        if (!$connect) {
            return false;
        }

        $values = DBUtil::executeSQL($sql);

        if (!$keepalive) {
            self::disconnectDB($connect);
        }
        return $values;
    }

    /**
     * Closes connection with the database
     * @param $connect
     */
    public static function disconnectDB($connect) {
        if ($connect) {
            Doctrine_Manager::getInstance()->closeConnection($connect);
       }
    }

    //Actions
    /**
     * Restore XTECAdmin action
     * @return bool succeed
     */
    public function restoreXtecadmin() {
        $operation = $this->addExecuteOperation('script_restore_xtecadmin');
        if (!$operation->has_succeeded()) {
            return LogUtil::registerError('Ha fallat la restauració de l\'usuari xtecadmin. Error:' . $operation->get_message());
        }
        LogUtil::registerStatus('S\'ha restaurat l\'usuari xtecadmin del Moodle del centre');
        return true;
    }

    /**
     * Show the list of files of the data directory
     *
     * @author Toni Ginard
     */
    public function getDataDirectory() {
        $agora = AgoraPortal_Util::getGlobalAgoraVars();

        return $agora['server']['root'] . get_filepath_moodle($this->activedId);
    }

    /**
     * Show the list of files of the data directory
     *
     * @author Toni Ginard
     */
    public function getDataDirectoryList() {
        $dataDir = $this->getDataDirectory();

        $this->printDataDir($dataDir);
    }
}
