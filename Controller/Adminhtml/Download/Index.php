<?php

namespace Rmlocke\Downloads\Controller\Adminhtml\Download;

/**
 * Downloads Download controller
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('Downloads')));

		return $resultPage;
	}
}
