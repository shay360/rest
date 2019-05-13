<?php
require('../exceptions/CampaignException.php');

class Campaign
{
    private $id;
    private $group;
    private $isActive;
    private $campaignObj;
    private $campaignAttachements;
    private $apiObj;
    private $campaignConditions;
    private $campaignPacks;
    private $triggers_obj;
    private $timeStamp;


    public function __construct($initObject)
    {
        $this->setID($initObject['id']);
        $this->setGroup($initObject['group_id']);
        $this->setStatus($initObject['is_active']);
        $this->setCampaignObj($initObject['campaign_obj']);
        $this->setAttachements($initObject['attachment_obj']);
        $this->setApiObj($initObject['api_obj']);
        $this->setCampaignConditions($initObject['conditions_obj']);
        $this->setCampaignPacks($initObject['packs_obj']);
        $this->setCampaignTriggers($initObject['triggers_obj']);
        $this->setTimestamp($initObject['timestamp']);
    }

    // getters
    public function getID()
    {
        return $this->id;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function getStatus()
    {
        return $this->isActive;
    }

    public function getCampiagnObj()
    {
        return $this->campaignObj;
    }

    public function getAttachements()
    {
        return $this->campaignAttachements;
    }

    public function getApiObj()
    {
        return $this->apiObj;
    }


    public function getCampaignConditions()
    {
        return $this->campaignConditions;
    }

    public function getCampaignPacks()
    {
        return $this->campaignPacks;
    }

    public function getTriggers()
    {
        return $this->triggers_obj;
    }

    public function getTimestamp()
    {
        return $this->timeStamp;
    }

    // setters
    private function setID($id)
    {
        if (is_numeric($id)) {
            $this->id = intval($id);
        } else {
            throw new CampaignException();
        }
    }

    private function setGroup($group)
    {
        if (is_numeric($group)) {
            $this->group = intval($group);
        } else {
            throw new CampaignException();
        }
    }

    private function setStatus($status)
    {
        if (is_numeric($status)) {
            $this->isActive = intval($status);
        } else {
            throw new CampaignException();
        }
    }

    private function setCampaignObj($campaignObj)
    {
        if (!empty($campaignObj)) {
            $this->campaignObj = $campaignObj;
        } else {
            throw new CampaignException('Campaign object cannot be empty');
        }
    }

    private function setAttachements($attachements)
    {
        if (!empty($attachements)) {
            $this->campaignAttachements = $attachements;
        } else {
            throw new CampaignException('Campaign attachements cannot be empty');
        }

    }

    private function setApiObj($apiObj)
    {
        if (!empty($apiObj)) {
            $this->apiObj = $apiObj;
        } else {
            throw new CampaignException('API Object cannot be empty');
        }
    }

    private function setCampaignConditions($conditions)
    {
        $this->campaignConditions = $conditions;
    }

    private function setCampaignPacks($packs)
    {
        $this->campaignPacks = $packs;
    }


    private function setCampaignTriggers($triggers)
    {
        $this->triggers_obj = $triggers;
    }


    private function setTimestamp($timestamp)
    {
        if (($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX)) {
            $this->timeStamp = $timestamp;
        } else {
            throw new CampaignException('Campaign timestamp is not legal');
        }
    }

    public function returnCampaignAsArray()
    {
        $campaign = [];
        $campaign['id'] = $this->getID();
        $campaign['group_id'] = $this->getGroup();
        $campaign['is_active'] = $this->getStatus() ? true : false;
        $campaign['campaign_obj'] = $this->getCampiagnObj();
        $campaign['campaign_attachements'] = $this->getAttachements();
        $campaign['api_obj'] = $this->getApiObj();
        $campaign['campaign_conditions'] = $this->getCampaignConditions();
        $campaign['campaign_packs'] = $this->getCampaignPacks();
        $campaign['campaign_triggers'] = $this->getTriggers();
        $campaign['timestamp'] = $this->getTimestamp();
        return $campaign;
    }
}
