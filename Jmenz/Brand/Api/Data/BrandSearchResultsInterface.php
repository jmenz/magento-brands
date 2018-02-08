<?php
namespace Jmenz\Brand\Api\Data;

/**
 * Jmenz Brand search results interface.
 * @package Jmenz\Brand
 * @api
 */
interface BrandSearchResultsInterface
{
    /**
     * Get brand list.
     *
     * @return \Jmenz\Brand\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set brands list.
     *
     * @param \Jmenz\Brand\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
