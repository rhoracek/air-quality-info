<?php
class UpdateController extends AbstractController {

    private $updater;

    public function __construct($dao, $updater) {
        parent::__construct();
        $this->updater = $updater;
        $this->dao = $dao;
    }

    public function update($device) {
        $this->authenticate($device);

        $payload = file_get_contents("php://input");
        $data = json_decode($payload, true);
        $sensors = $data['sensordatavalues'];
        
        $map = array();
        foreach ($sensors as $row) {
            $map[$row['value_type']] = $row['value'];
        }
        
        if ($device['esp8266id'] != $data['esp8266id']) {
            error_log('esp8266id mismatch. Expected: '.$device['esp8266id'].' but got '.$data['esp8266id']);
            exit;
        }
    
        if (CONFIG['store_json_payload']) {
            $this->dao->logJsonUpdate($device['esp8266id'], time(), $payload);
        }

        $this->updater->update($device, $map);
    }

    public function update_raw($device, $id) {
        $payload = file_get_contents("php://input");
        error_log ("[update_raw] payload: [$payload]");
        error_log ("[update_raw] REQUEST: " . var_export($_REQUEST, true));
        error_log ("[update_raw] POST: " . var_export($_POST, true));
        error_log ("[update_raw] SERVER: " . var_export($_SERVER, true));
        echo "Data recieved";
    }
}

?>