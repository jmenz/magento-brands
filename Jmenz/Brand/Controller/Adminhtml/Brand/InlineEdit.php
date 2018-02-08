<?php
namespace Jmenz\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action\Context;
use Jmenz\Brand\Api\Data\BrandInterface;
use Jmenz\Brand\Api\BrandRepositoryInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class InlineEdit
 * @package Jmenz\Brand
 */
class InlineEdit extends AbstractAction
{

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $jsonFactory;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;

    /**
     * @param Context $context
     * @param BrandRepositoryInterface $brandRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        BrandRepositoryInterface $brandRepository,
        JsonFactory $jsonFactory
    ) {
        $this->brandRepository = $brandRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (empty($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $id) {
                    try {
                        /** @var BrandInterface $model */
                        $model = $this->brandRepository->getById($id);
                        $model->setData(array_merge($model->getData(), $postItems[$id]));
                        $this->brandRepository->save($model);
                    } catch (NoSuchEntityException $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    } catch (CouldNotSaveException $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    } catch (\Exception $e) {
                        $messages[] = $e->getMessage();
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
