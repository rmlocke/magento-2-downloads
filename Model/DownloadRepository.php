<?php

namespace Rmlocke\Downloads\Model;


use Rmlocke\Downloads\Api\DownloadRepositoryInterface;
use Rmlocke\Downloads\Api\Data\DownloadInterfaceFactory as ModelFactory;
use Rmlocke\Downloads\Model\ResourceModel\Download as ResourceModel;
use Rmlocke\Downloads\Model\ResourceModel\Download\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Rmlocke\Downloads\Api\Data\DownloadSearchResultInterfaceFactory;
use Psr\Log\LoggerInterface;

class DownloadRepository implements DownloadRepositoryInterface
{

    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var \Rmlocke\Downloads\Api\Data\DownloadInterface[]
     */
    protected $objectCache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var DownloadSearchResultInterfaceFactory
     */
    private $DownloadSearchResultFactory;

    /**
     * DownloadRepository constructor.
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param DownloadSearchResultInterfaceFactory $DownloadSearchResultFactory
     * @param LoggerInterface $logger
     * @param array $objectCache
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        DownloadSearchResultInterfaceFactory $DownloadSearchResultFactory,
        LoggerInterface $logger,
        array $objectCache = []
    )
    {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->DownloadSearchResultFactory = $DownloadSearchResultFactory;
        $this->logger = $logger;
        $this->objectCache = $objectCache;
    }

    /**
     * @param int $id
     * @param bool $loadFromCache
     * @return \Rmlocke\Downloads\Api\Data\DownloadInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function loadById(int $id, bool $loadFromCache = true): \Rmlocke\Downloads\Api\Data\DownloadInterface
    {
        $cachedObject = $this->getCachedObject('id', $id);
        if ($loadFromCache && $cachedObject) {
            return $cachedObject;
        } else {
            $model = $this->create();
            $this->resourceModel->load($model, $id);
            if (!$model->getEntityId()) {
                throw NoSuchEntityException::singleField('entity_id', $id);
            }
            $this->cacheObject('id', $id, $model);
            return $model;
        }
    }

    /**
     * @return \Rmlocke\Downloads\Api\Data\DownloadInterface
     */
    public function create(): \Rmlocke\Downloads\Api\Data\DownloadInterface
    {
        return $this->modelFactory->create();
    }

    /**
     * @param \Rmlocke\Downloads\Api\Data\DownloadInterface $Download
     * @return \Rmlocke\Downloads\Api\Data\DownloadInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Rmlocke\Downloads\Api\Data\DownloadInterface $Download): \Rmlocke\Downloads\Api\Data\DownloadInterface
    {
        try {
            $this->resourceModel->save($Download);
            return $this->loadById($Download->getEntityId(), false);
        } catch (AlreadyExistsException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('There was some error saving the Download'));
        }
    }

    /**
     * @param \Rmlocke\Downloads\Api\Data\DownloadInterface $Download
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Rmlocke\Downloads\Api\Data\DownloadInterface $Download): bool
    {
        try {
            $this->resourceModel->delete($Download);
            $this->cacheObject('id', $Download->getEntityId(), null);
            return true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__('There was some eror deleting the Download'));
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->loadById($id));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Rmlocke\Downloads\Api\Data\DownloadSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Rmlocke\Downloads\Api\Data\DownloadSearchResultInterface $searchResult */
        $searchResult = $this->DownloadSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria)
            ->setTotalCount($collection->getSize())
            ->setItems($collection->getItems());
        foreach ($searchResult->getItems() as $item) {
            $this->cacheObject('id', $item->getEntityId(), $item);
        }
        return $searchResult;
    }

    /**
     * @return \Rmlocke\Downloads\Model\ResourceModel\Download\Collection
     */
    public function getCollection(): \Rmlocke\Downloads\Model\ResourceModel\Download\Collection
    {
        return $this->collectionFactory->create();
    }

    /**
     * @param string $type
     * @param string $identifier
     * @param \Rmlocke\Downloads\Api\Data\DownloadInterface|null $object
     */
    protected function cacheObject($type, $identifier, $object)
    {
        $cacheKey = $this->getCacheKey($type, $identifier);
        $this->objectCache[$cacheKey] = $object;
    }

    /**
     * @param string $type
     * @param string $identifier
     * @return bool|\Rmlocke\Downloads\Api\Data\DownloadInterface
     */
    protected function getCachedObject($type, $identifier)
    {
        $cacheKey = $this->getCacheKey($type, $identifier);
        return $this->objectCache[$cacheKey] ?? false;
    }

    protected function getCacheKey($type, $identifier)
    {
        return $type . '_' . $identifier;
    }
}
