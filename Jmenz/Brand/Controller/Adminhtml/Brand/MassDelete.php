<?php
namespace Jmenz\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Jmenz\Brand\Api\BrandRepositoryInterface;
use Jmenz\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class MassDelete
 * @package Jmenz\Brand
 */
class MassDelete extends AbstractAction
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
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        CollectionFactory $collectionFactory,
        Filter $filter,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->filter = $filter;
        $this->brandRepository = $brandRepository;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        try {
            foreach ($collection as $brand) {
                $this->brandRepository->delete($brand);
            }
            $message = __('A total of %1 record(s) have been deleted.', $collection->getSize());
            $this->messageManager->addSuccessMessage($message);
            $this->dataPersistor->clear('brand');
            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while deleting brands.'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
