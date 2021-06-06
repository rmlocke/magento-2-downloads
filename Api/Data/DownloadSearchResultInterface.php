<?php

namespace Rmlocke\Downloads\Api\Data;

interface DownloadSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Rmlocke\Downloads\Api\Data\DownloadInterface[]
     */
    public function getItems();

    /**
     * @param \Rmlocke\Downloads\Api\Data\DownloadInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
