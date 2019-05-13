<?php
require('../exceptions/CampaignsException.php');

class Campaigns
{
    private $id;
    private $campaignName;
    private $campaignType;
    private $startDate;
    private $endDate;
    private $banner;
    private $circle;
    private $isActive;
    private $updateTime;

    public function __construct($initObject)
    {
        $this->setID($initObject['id']);
        $this->setName($initObject['campaign_name']);
        $this->setType($initObject['campaign_type']);
        $this->setStartDate($initObject['start_date']);
        $this->setEndDate($initObject['end_date']);
        $this->setBanner($initObject['banner']);
        $this->setCircle($initObject['circle']);
        $this->setStatus($initObject['is_active']);
        $this->setUpdateTime($initObject['update_time']);
    }

    // getters
    public function getID()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->campaignName;
    }

    public function getType()
    {
        return $this->campaignType;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getBanner()
    {
        return $this->banner;
    }

    public function getCircle()
    {
        return $this->circle;
    }

    public function getStatus()
    {
        return $this->isActive;
    }

    public function getUpdateDate()
    {
        return $this->updateTime;
    }

    // setters

    /**
     * @param $id
     * @throws CampaignException
     */
    private function setID($id)
    {
        if (is_numeric($id) && !empty($id)) {
            $this->id = intval($id);
        } else {
            throw new CampaignException('Campaign ID Error');
        }
    }

    private function setName($name)
    {
        if (is_string($name)) {
            $this->campaignName = filter_var($name, FILTER_SANITIZE_STRING);
        } else {
            throw new CampaignsException('Campaign name must be a string');
        }
    }

    private function setType($type)
    {
        if (is_numeric($type)) {
            $this->campaignType = intval($type);
        } else {
            throw new CampaignException('Campaign type need to be pass as int');
        }
    }


    private function setStartDate($startDate)
    {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $startDate) !== false) {
            $this->startDate = $startDate;
        } else {
            throw new CampaignException('Start date must be in exceptable date format');
        }
    }

    private function setEndDate($endDate)
    {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $endDate) !== false) {
            $this->endDate = $endDate;
        } else {
            throw new CampaignException('End date must be in exceptable date format');
        }
    }

    private function setBanner($banner)
    {
        if (is_string($banner)) {
            $this->banner = filter_var($banner, FILTER_SANITIZE_STRING);
        } else {
            throw new CampaignException('Campaign banner data type is incorrect');
        }
    }

    private function setCircle($circle)
    {
        if (is_string($circle)) {
            $this->circle = filter_var($circle, FILTER_SANITIZE_STRING);
        } else {
            throw new CampaignException('Campaign circle (Icon) data type is incorrect');
        }
    }

    private function setStatus($status)
    {
        if (is_numeric($status)) {
            $this->isActive = intval($status);
        } else {
            throw new CampaignException('Camapaign status need to be integer');
        }
    }


    private function setUpdateTime($updateTime)
    {
        if (DateTime::createFromFormat('Y-m-d H:i:s', $updateTime) !== false) {
            $this->updateTime = $updateTime;
        } else {
            throw new CampaignException('Update Time must be in exceptable date format');
        }
    }

    public function returnCampaignsAsArray()
    {
        $campaign = [];
        $campaign['id'] = $this->getID();
        $campaign['name'] = $this->getName();
        $campaign['campaign_type'] = $this->getType();
        $campaign['start_date'] = $this->getStartDate();
        $campaign['end_date'] = $this->getEndDate();
        $campaign['banner'] = $this->getBanner();
        $campaign['circle'] = $this->getCircle();
        $campaign['is_active'] = $this->getStatus() ? true : false;
        $campaign['update_time'] = $this->getUpdateDate();
        return $campaign;
    }
}
