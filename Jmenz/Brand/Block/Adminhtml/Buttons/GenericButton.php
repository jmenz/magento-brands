<?php
namespace Jmenz\Brand\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Jmenz\Brand\Api\BrandRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 * @package Jmenz\Brand
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->context = $context;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return int|null
     */
    public function getBrandId()
    {
        try {
            return $this->brandRepository->getById(
                $this->context->getRequest()->getParam('brand_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
