<?php

namespace Rmlocke\Downloads\Api;

interface DownloadRepositoryInterface
{
    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Rmlocke\Downloads\Api\Data\DownloadInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Rmlocke\Downloads\\Api\Data\DownloadInterface;

    /**
     * @return \Rmlocke\Downloads\\Api\Data\DownloadInterface
     */
    public function create(): \Rmlocke\Downloads\\Api\Data\DownloadInterface;

    /**
     * @param \Rmlocke\Downloads\Api\Data\DownloadInterface $download
     * @return \Rmlocke\Downloads\Api\Data\DownloadInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Rmlocke\Downloads\Api\Data\DownloadInterface $download): \Rmlocke\Downloads\Api\Data\DownloadInterface;

    /**
     * @param \Rmlocke\Downloads\Api\Data\DownloadInterface $download
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Rmlocke\Downloads\Api\Data\DownloadInterface $download): bool;

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Rmlocke\Downloads\Api\Data\DownloadSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @return \Rmlocke\Downloads\Model\ResourceModel\Download\Collection
     */
    public function getCollection(): \Rmlocke\Downloads\Model\ResourceModel\Download\Collection;
}
