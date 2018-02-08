<?php
namespace Jmenz\Brand\Block\Product\Brand;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Jmenz\Brand\Api\BrandRepositoryInterface;

/**
 * Class Listing
 * @package Jmenz\Brand
 */
class Listing extends Template
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @var Product
     */
    protected $product = null;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @param Template\Context $context
     * @param Registry $registry
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BrandRepositoryInterface $brandRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BrandRepositoryInterface $brandRepository,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->brandRepository = $brandRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList()
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('brand_id', $this->getProduct()->getBrands(), 'in')
            ->create();
        $list = $this->brandRepository->getList($searchCriteria);
        return $list;
    }

    /**
     * @param string $logoFileName
     * @return string
     */
    public function getLogoUrl($logoFileName)
    {
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . 'brand/' . $logoFileName;
    }

    /**
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    protected function getProduct()
    {
        if (!$this->product) {
            $this->product = $this->coreRegistry->registry('product');
        }
        return $this->product;
    }
}
