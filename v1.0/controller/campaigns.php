<?php

// Import important files
require_once('DB.php'); // DB Configuration
require_once('../model/Campaigns.php'); // import the campaigns model
require_once('../exceptions/CampaignsException.php'); // import the campaigns model
require_once('../router/Response.php'); // import the response class

$serverMethod = $_SERVER['REQUEST_METHOD']; // get the request method

try { // try to connect DB
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
} catch (PDOException $e) { // if connection failed
    error_log('DB Connection error: ' . $e->getMessage(), 0);
    $response = new Response();
    $response->setHttpStatusCode(500);
    $response->setSuccess(false);
    $response->addMessage('DB Connection error: ' . $e->getMessage());
    $response->send();
    exit;
}
header('Content-type: application/json;charset=utf-8'); // set headers to json

if ($serverMethod === 'GET') { // build the get method
    try {
        $query = $readDB->prepare('SELECT campaign_id, `name`, campaign_type, start_date, end_date, banner, circle, is_active, update_time FROM bms_table');
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount === 0) {
            $response = new Response();
            $response->setHttpStatusCode(404);
            $response->setSuccess(false);
            $response->addMessage('No Campaigns Found');
            $response->send();
            exit;
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
        $response = new Response();
        $response->setHttpStatusCode(500);
        $response->setSuccess(false);
        $response->addMessage('Query Error');
        $response->send();
        exit;
    } catch (PDOException $e) {
        error_log('DB Connection error: ' . $e->getMessage(), 0);
        $response = new Response();
        $response->setHttpStatusCode(500);
        $response->setSuccess(false);
        $response->addMessage('DB Connection error: ' . $e->getMessage());
        $response->send();
        exit;
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
    $response = new Response();
    $response->setHttpStatusCode(405);
    $response->setSuccess(false);
    $response->addMessage('Request method is not allowed');
    $response->send();
    exit;
}
