<?php
require('../exceptions/CampaignsException.php');

class Campaigns
{
    private $id;
    private $campaignObject;

    public function __construct($initObject)
    {
        $this->setID($initObject['id']);
        $this->setCampaignObject($initObject['campaign_obj']);
    }

    // getters
    public function getID()
    {
        return $this->id;
    }

    public function getCampaignObject()
    {
        return $this->campaignObject;
    }
    // setters

    /**
     * @param $id
     * @throws CampaignException
     */
    public function setID($id)
    {
        if (is_numeric($id) && !empty($id)) {
            $this->id = intval($id);
        } else {
            throw new CampaignException('Post ID Error');
        }
    }

    public function setCampaignObject($campaignObject)
    {
        $this->campaignObject = $campaignObject;
    }

    public function returnCampaignsAsArray()
    {
        $campaign = [];
        $campaign['id'] = $this->getID();
        $campaign['campaign_obj'] = $this->getCampaignObject();
        return $campaign;
    }

    // Get single Campaign by ID
}
