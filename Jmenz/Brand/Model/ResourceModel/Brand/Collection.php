<?php
namespace Jmenz\Brand\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Jmenz\Brand
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'brand_id';

    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Jmenz\Brand\Model\Brand',
            'Jmenz\Brand\Model\ResourceModel\Brand'
        );
    }
}
