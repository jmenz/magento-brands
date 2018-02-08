<?php
namespace Jmenz\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Jmenz\Brand\Api\Data\BrandInterface;
use Jmenz\Brand\Model\BrandFactory;
use Jmenz\Brand\Api\BrandRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class Save
 * @package Jmenz\Brand
 */
class Save extends AbstractAction
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
     * @var BrandFactory
     */
    private $brandFactory;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     * @param BrandFactory $brandFactory
     * @param DataPersistorInterface $dataPersistor
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        BrandFactory $brandFactory,
        DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->brandRepository = $brandRepository;
        $this->brandFactory = $brandFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('brand_id');

            if (empty($data['brand_id'])) {
                $data['brand_id'] = null;
            }

            if ($id) {
                try {
                    /** @var BrandInterface $model */
                    $model = $this->brandRepository->getById($id);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__($e->getMessage()));
                    /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            } else {
                /** @var BrandInterface $model */
                $model = $this->brandFactory->create();
            }
            $this->processImage($data);
            $model->setData($data);

            try {
                $this->brandRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the brand.'));
                $this->dataPersistor->clear('brand');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['brand_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the brand.'));
            }

            $this->dataPersistor->set('brand', $data);
            return $resultRedirect->setPath('*/*/edit', ['brand_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return array
     */
    private function processImage(&$data)
    {
        $this->filePreprocessing($data, 'logo');
        $this->filterFileData($data, 'logo');
        $this->moveImage($data, 'logo');
    }

    /**
     * @param array $data
     * @param string $fieldName
     */
    private function filterFileData(&$data, $fieldName)
    {
        if (isset($data[$fieldName]) && is_array($data[$fieldName])) {
            if (!empty($data[$fieldName]['delete'])) {
                $data[$fieldName] = null;
            } else {
                if (isset($data[$fieldName][0]['name']) && isset($data[$fieldName][0]['tmp_name'])) {
                    $data[$fieldName] = $data[$fieldName][0]['name'];
                } else {
                    unset($data[$fieldName]);
                }
            }
        }
    }

    /**
     * @param array $data
     * @param string $fieldName
     */
    private function filePreprocessing(&$data, $fieldName)
    {
        if (empty($data[$fieldName])) {
            unset($data[$fieldName]);
            $data[$fieldName]['delete'] = true;
        }
    }

    /**
     * @param array $data
     * @param string $fieldName
     */
    private function moveImage(&$data, $fieldName)
    {
        if ($data[$fieldName]) {
            $this->imageUploader->moveFileFromTmp($data[$fieldName]);
        }
    }
}
