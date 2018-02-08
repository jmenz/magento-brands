<?php
namespace Jmenz\Brand\Model\Brand;

use Jmenz\Brand\Api\Data\BrandInterface;
use Jmenz\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Jmenz\Brand\Model\ResourceModel\Brand\Collection as BrandCollection;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\UrlInterface;

/**
 * Class DataProvider
 * @package Jmenz\Brand
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var BrandCollection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $brandCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param UrlInterface $urlBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $brandCollectionFactory,
        DataPersistorInterface $dataPersistor,
        UrlInterface $urlBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $brandCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var BrandInterface $brand */
        foreach ($items as $brand) {
            $this->loadedData[$brand->getId()] = $this->prepareData($brand);
        }

        $data = $this->dataPersistor->get('brand');
        if (!empty($data)) {
            $brand = $this->collection->getNewEmptyItem();
            $brand->setData($data);
            $this->loadedData[$brand->getId()] = $this->prepareData($brand);
            $this->dataPersistor->clear('brand');
        }

        return $this->loadedData;
    }

    /**
     * @param BrandInterface $brand
     */
    private function prepareData($brand)
    {
        $data = $brand->getData();

        if (isset($data['logo'])) {
            unset($data['logo']);
            $data['logo'][0]['name'] = $brand->getData('logo');
            $data['logo'][0]['url'] = $this->getFileUrl($brand->getLogo());
        }

        return $data;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getFileUrl($fileName)
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'brand/' . $fileName;
    }
}
