<?php
namespace AirQualityInfo\Api\Controller;

class UpdateController {

    private $updater;

    private $jsonUpdateModel;

    private $deviceModel;

    public function __construct(
            \AirQualityInfo\Model\Updater $updater,
            \AirQualityInfo\Model\JsonUpdateModel $jsonUpdateModel,
            \AirQualityInfo\Model\DeviceModel $deviceModel) {
        $this->updater = $updater;
        $this->jsonUpdateModel = $jsonUpdateModel;
        $this->deviceModel = $deviceModel;
    }

    public function updateWithKey($key) {
        $device = $this->deviceModel->getDeviceByApiKey($key);
        if (!$device) {
            $this->authError();
        }
        $payload = file_get_contents("php://input");
        $data = json_decode($payload, true);
        $device['mapping'] = $this->deviceModel->getMappingAsAMap($device['id']);

        $sensors = $data['sensordatavalues'];
        $map = array();
        foreach ($sensors as $row) {
            $map[$row['value_type']] = $row['value'];
        }
        
        $this->jsonUpdateModel->logJsonUpdate($device['id'], time(), $payload);
        $this->updater->update($device, $map);
    }

    private function authError() {
        header('WWW-Authenticate: Basic realm="Air Quality Info Page"');
        header('HTTP/1.0 401 Unauthorized');
        die();
    }
}

?>