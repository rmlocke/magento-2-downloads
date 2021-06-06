<?php

namespace Rmlocke\Downloads\Controller\Adminhtml\Download;

use Magento\Framework\Controller\ResultFactory;
use Rmlocke\Downloads\Api\DownloadRepositoryInterface;

class Edit extends \Magento\Backend\App\Action
{

    /**
     * @var DownloadRepositoryInterface
     */
    private $downloadRepository;

    /**
     * Constructor
     *
     * @param Action\Context $context
     * @param DownloadRepositoryInterface $downloadRepository
     */
    public function __construct(
        Action\Context $context,
        DownloadRepositoryInterface $downloadRepository
    )
    {
        parent::__construct($context);
        $this->downloadRepository = $downloadRepository;
    }

    /**
     * Action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $id = $this->getRequest()->getParam('entity_id');

        if ($id) {
            $download = $this->downloadRepository->loadById($id);
            $page->getConfig()->getTitle()->set(__('Edit Download "%1" (%2)', $download->getTitle(), $download->getEntityId()));
        } else {
            $page->getConfig()->getTitle()->set(__('Create New Download'));
        }

        return $resultPage;
    }
}
