<?php
namespace Jmenz\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Jmenz\Brand\Model\BrandFactory;
use Jmenz\Brand\Api\BrandRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Edit
 * @package Jmenz\Brand
 */
class Edit extends AbstractAction
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     * @param BrandFactory $brandFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        BrandFactory $brandFactory,
        PageFactory $resultPageFactory
    ) {
        $this->brandRepository = $brandRepository;
        $this->brandFactory = $brandFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('brand_id');

        if ($id) {
            try {
                $model = $this->brandRepository->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->brandFactory->create();
        }

        /** @var ResultInterface $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Jmenz_Brand::brands');

        $resultPage->getConfig()->getTitle()->prepend(__('Brand'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Brand'));
        return $resultPage;
    }
}
