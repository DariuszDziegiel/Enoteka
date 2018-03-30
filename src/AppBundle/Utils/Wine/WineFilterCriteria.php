<?php
namespace AppBundle\Utils\Wine;

use Doctrine\ORM\EntityManager;

class WineFilterCriteria {
    
    private $em;
    private $priceRangeMin;
    private $priceRangeMax;
    private $yearRangeMin;
    private $yearRangeMax;
    private $wineColor;
    private $wineMaturity;
    private $wineCountry;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getWineCountry() {
        return $this->wineCountry;
    }

    public function getWineColor() {
        return $this->wineColor;
    }

    public function getWineMaturity() {
        return $this->wineMaturity;
    }

    public function getPriceRangeMin() {
        return $this->priceRangeMin;
    }

    public function getPriceRangeMax() {
        return $this->priceRangeMax;
    }

    public function getYearRangeMin() {
        return $this->yearRangeMin;
    }

    public function getYearRangeMax() {
        return $this->yearRangeMax;
    }

    public function setPriceRange($min, $max) {
        if ($min > $max) {
            $max = $min;
        }
        $this->priceRangeMin = $min;
        $this->priceRangeMax = $max;
        return $this;
    }
    
    public function setYearRange($min, $max) {
        if ($min > $max) {
            $max = $min;
        }
        $this->yearRangeMin = $min;
        $this->yearRangeMax = $max;
        return $this;
    }
    
    public function setWineColor($wineColor) {
        $this->wineColor = $wineColor;
        return $this;
    }
    
    public function setWineMaturity($wineMaturity) {
        $this->wineMaturity = $wineMaturity;
        return $this;
    }
    
    public function setWineCountry($wineCountry) {
        $this->wineCountry = $wineCountry;
        return $this;
    }

}