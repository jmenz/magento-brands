<?php
namespace Jmenz\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Jmenz\Brand\Api\BrandRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Delete
 */
class Delete extends AbstractAction
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->brandRepository = $brandRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('brand_id');

        try {
            $this->brandRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the brand'));
            $this->dataPersistor->clear('brand');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting the brand.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
