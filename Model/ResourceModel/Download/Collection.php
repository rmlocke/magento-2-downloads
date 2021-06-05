<?php

namespace Rmlocke\Downloads\Model\ResourceModel\Download;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Download Collection Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Rmlocke\Downloads\Model\Download', 'Rmlocke\Downloads\Model\ResourceModel\Download');
    }
}
