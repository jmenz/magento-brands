<?php
namespace Jmenz\Brand\Model\Product\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Jmenz\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Jmenz\Brand\Api\Data\BrandInterface;

/**
 * Class Brand
 * @package Jmenz\Brand
 */
class Brand extends AbstractSource
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [];

            $collection = $this->collectionFactory->create();

            /** @var BrandInterface $brand */
            foreach ($collection as $brand) {
                $this->_options[] = ['label' => __($brand->getName()), 'value' => $brand->getId()];
            }
        }
        return $this->_options;
    }
}
