<?php

namespace AppBundle\Entity;

/**
 * Offices
 */
class Offices
{
    /**
     * @var string
     */
    private $street = '';

    /**
     * @var string
     */
    private $city = '';

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $isOpenInWeekends = 'N';

    /**
     * @var string
     */
    private $hasSupportDesk = 'N';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set street
     *
     * @param string $street
     *
     * @return Offices
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Offices
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Offices
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Offices
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set isOpenInWeekends
     *
     * @param string $isOpenInWeekends
     *
     * @return Offices
     */
    public function setIsOpenInWeekends($isOpenInWeekends)
    {
        $this->isOpenInWeekends = $isOpenInWeekends;

        return $this;
    }

    /**
     * Get isOpenInWeekends
     *
     * @return string
     */
    public function getIsOpenInWeekends()
    {
        return $this->isOpenInWeekends;
    }

    /**
     * Set hasSupportDesk
     *
     * @param string $hasSupportDesk
     *
     * @return Offices
     */
    public function setHasSupportDesk($hasSupportDesk)
    {
        $this->hasSupportDesk = $hasSupportDesk;

        return $this;
    }

    /**
     * Get hasSupportDesk
     *
     * @return string
     */
    public function getHasSupportDesk()
    {
        return $this->hasSupportDesk;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

