<?php

namespace Rmlocke\Downloads\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Download extends AbstractDb
{
    /**
     * Download Abstract Resource Constructor
     * @return void
     */
    protected function _construct()
    {
        $this->_init('rmlocke_download', 'download_id');
    }
}
