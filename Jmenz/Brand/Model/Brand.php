<?php
namespace Jmenz\Brand\Model;

use Magento\Framework\Model\AbstractModel;
use Jmenz\Brand\Api\Data\BrandInterface;

/**
 * Class Brand
 * @package Jmenz\Brand
 */
class Brand extends AbstractModel implements BrandInterface
{
    /**
     * Set resource model
     */
    protected function _construct()
    {
        $this->_init('Jmenz\Brand\Model\ResourceModel\Brand');
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->getData(self::BRAND_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * {@inheritDoc}
     */
    public function getFoundationYear()
    {
        return $this->getData(self::FOUNDATION_YEAR);
    }

    /**
     * {@inheritDoc}
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        return $this->setData(self::BRAND_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * {@inheritDoc}
     */
    public function setFoundationYear($foundation_year)
    {
        return $this->setData(self::FOUNDATION_YEAR, $foundation_year);
    }

    /**
     * {@inheritDoc}
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }
}
