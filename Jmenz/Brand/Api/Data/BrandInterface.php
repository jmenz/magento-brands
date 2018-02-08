<?php
namespace Jmenz\Brand\Api\Data;

/**
 * Jmenz Brand interface
 * @package Jmenz\Brand
 * @api
 */
interface BrandInterface
{
    const BRAND_ID = 'brand_id';
    const NAME = 'name';
    const COUNTRY = 'country';
    const FOUNDATION_YEAR = 'foundation_year';
    const LOGO = 'logo';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get Country
     *
     * @return string|null
     */
    public function getCountry();

    /**
     * Get Foundation Year
     *
     * @return int|null
     */
    public function getFoundationYear();

    /**
     * Get Logo
     *
     * @return string|null
     */
    public function getLogo();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get Updated At
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set ID
     *
     * @param int $id
     * @return BrandInterface
     */
    public function setId($id);

    /**
     * Set Name
     *
     * @param string $name
     * @return BrandInterface
     */
    public function setName($name);

    /**
     * Set Country
     *
     * @param string $country
     * @return BrandInterface
     */
    public function setCountry($country);

    /**
     * Set Foundation Year
     *
     * @param string $foundation_year
     * @return BrandInterface
     */
    public function setFoundationYear($foundation_year);

    /**
     * Set Logo
     *
     * @param string $logo
     * @return BrandInterface
     */
    public function setLogo($logo);
}
