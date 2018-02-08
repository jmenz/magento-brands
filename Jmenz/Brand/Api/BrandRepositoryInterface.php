<?php
namespace Jmenz\Brand\Api;

/**
 * Jmenz BrandRepository interface.
 * @package Jmenz\Brand
 * @api
 */
interface BrandRepositoryInterface
{
    /**
     * Save brand.
     *
     * @param \Jmenz\Brand\Api\Data\BrandInterface $brand
     * @return \Jmenz\Brand\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\BrandInterface $brand);

    /**
     * Retrieve brand.
     *
     * @param int $brandId
     * @return \Jmenz\Brand\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($brandId);

    /**
     * Get brands list.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete brand.
     *
     * @param \Jmenz\Brand\Api\Data\BrandInterface $brand
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\BrandInterface $brand);

    /**
     * Delete brand by ID.
     *
     * @param int $brandId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($brandId);
}
