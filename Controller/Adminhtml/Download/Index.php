<?php

namespace Rmlocke\Downloads\Controller\Adminhtml\Download;

/**
 * Downloads Download controller
 * @package Rmlocke_Downloads
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
	protected $resultPageFactory = false;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

    /**
     * Action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('Downloads')));

		return $resultPage;
	}
}
