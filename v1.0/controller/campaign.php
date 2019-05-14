<?php
require_once ('../init.php');
require_once('../model/Campaign.php'); // import the campaigns model

$serverMethod = $_SERVER['REQUEST_METHOD']; // get the request method
try { // try to connect DB
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
} catch (PDOException $e) { // if connection failed
    error_log('DB Connection error: ' . $e->getMessage(), 0);
    $response = Utils::setErrorResponse(_STATUS_INTERNAL_SERVER_ERROR);
}
header('Content-type: application/json;charset=utf-8'); // set headers to json
if ($serverMethod === 'GET') {
    if (array_key_exists('id', $_GET)) {
        $campaignID = $_GET['id'];
        if (empty($campaignID) || !is_numeric($campaignID)) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage('Campaign ID must be numeric (int)');
            $response->send();
            exit;
        }
        try {
            $query = $readDB->prepare("SELECT * FROM bms_extractor WHERE extractor_id = ?");
            $query->bindParam(1, $campaignID, PDO::PARAM_INT);
            $query->execute();
            $rowCount = $query->rowCount();
            if ($rowCount === 0) {
                $response = Utils::setErrorResponse(_STATUS_NO_CONTENT);
            }
            $constructorObject = [];
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $constructorObject['id'] = $row['extractor_id'];
                $constructorObject['group_id'] = $row['group_id'];
                $constructorObject['is_active'] = $row['is_active'];
                $constructorObject['campaign_obj'] = $row['campaign_obj'];
                $constructorObject['attachment_obj'] = $row['attachment_obj'];
                $constructorObject['api_obj'] = $row['api_obj'];
                $constructorObject['conditions_obj'] = $row['conditions_obj'];
                $constructorObject['packs_obj'] = $row['packs_obj'];
                $constructorObject['triggers_obj'] = $row['triggers_obj'];
                $constructorObject['timestamp'] = $row['timestamp'];
                $campaign = new Campaign($constructorObject);
                $campaignArray[] = $campaign->returnCampaignAsArray();
            }
            $returnData = [];
            $returnData['count'] = $rowCount;
            $returnData['results'] = $campaignArray;
            $response = new Response();
            $response->setHttpStatusCode(200);
            $response->setSuccess(true);
            $response->toCache(true);
            $response->setData($returnData);
            $response->send();
            exit;
        } catch (CampaignException $e) {

        }
    } else {
        $response = Utils::setErrorResponse(_STATUS_BAD_REQUEST);
    }
} elseif ($serverMethod === 'POST') {

} elseif ($serverMethod === 'PUT') {

} elseif ($serverMethod === 'OPTIONS') {
    echo json_encode([
            'methods' => [
                'GET' => [
                    'description' => 'Will return a single campaign details',
                    'args' => [
                        'id' => [
                            'type' => 'int',
                            'required' => true
                        ]
                    ]
                ]
            ]
        ]
    );
} else {
    $response = Utils::setErrorResponse(_STATUS_MOETHOD_NOT_ALLOWED);
}