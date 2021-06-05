<?php

namespace Rmlocke\Downloads\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Rmlocke\Downloads\Model\ResourceModel\Download\Collection as DownloadCollection;
use \Rmlocke\Downloads\Model\ResourceModel\Download\CollectionFactory as downloadCollectionFactory;
use \Rmlocke\Downloads\Model\Download;

class Dwonloads extends Template
{
    /**
     * CollectionFactory
     * @var null|CollectionFactory
     */
    protected $_downloadCollectionFactory = null;

    /**
     * Constructor
     *
     * @param Context $context
     * @param DownloadCollectionFactory $downloadCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        DownloadCollectionFactory $downloadCollectionFactory,
        array $data = []
    ) {
        $this->_downloadCollectionFactory = $downloadCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return Download[]
     */
    public function getDownloads()
    {
        /** @var DownloadCollection $downloadCollection */
        $downloadCollection = $this->_downloadCollectionFactory->create();
        $downloadCollection->addFieldToSelect('*')->load();
        return $downloadCollection->getItems();
    }
}
