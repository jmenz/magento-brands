<?php
namespace Jmenz\Brand\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Brand
 * Resource Model
 * @package Jmenz\Brand
 */
class Brand extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('jmenz_brand', 'brand_id');
    }
}
