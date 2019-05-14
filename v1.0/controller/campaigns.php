<?php
require_once('../init.php');
require_once('../model/Campaigns.php');

$serverMethod = $_SERVER['REQUEST_METHOD'];

try { // try to connect DB
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
} catch (PDOException $e) { // if connection failed
    error_log('DB Connection error: ' . $e->getMessage(), 0);
    $response = Utils::setErrorResponse(_STATUS_INTERNAL_SERVER_ERROR);
}
header('Content-type: application/json;charset=utf-8'); // set headers to json

if ($serverMethod === 'GET') { // build the get method
    try {
        $query = $readDB->prepare('SELECT campaign_id, `name`, campaign_type, start_date, end_date, banner, circle, is_active, update_time FROM bms_table');
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount === 0) {
            $response = Utils::setErrorResponse(_STATUS_NO_CONTENT);
        }
        $constructorObject = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $constructorObject['id'] = $row['campaign_id'];
            $constructorObject['campaign_name'] = $row['name'];
            $constructorObject['campaign_type'] = $row['campaign_type'];
            $constructorObject['start_date'] = $row['start_date'];
            $constructorObject['end_date'] = $row['end_date'];
            $constructorObject['banner'] = $row['banner'];
            $constructorObject['circle'] = $row['circle'];
            $constructorObject['is_active'] = $row['is_active'];
            $constructorObject['update_time'] = $row['update_time'];
            $campaign = new Campaigns($constructorObject);
            $campaignArray[] = $campaign->returnCampaignsAsArray();
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
    } catch (CampaignsException $e) {
        error_log('Query Error', 0);
        $response = Utils::setErrorResponse(_STATUS_INTERNAL_SERVER_ERROR);
    } catch (PDOException $e) {
        error_log('DB Connection error: ' . $e->getMessage(), 0);
        $response = Utils::setErrorResponse(_STATUS_INTERNAL_SERVER_ERROR);
    }
} elseif ($serverMethod === 'OPTIONS') { // build the options method
    echo json_encode([
            'methods' => [
                'GET' => [
                    'description' => 'Will return all campaigns headers',
                    'args' => [
                    ]
                ]
            ]
        ]
    );
} else { // if the request method is not allowed by this endpoint
    $response = Utils::setErrorResponse(_STATUS_NOT_IMPLEMNTED);
}
