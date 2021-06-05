<?php

namespace Rmlocke\Downloads\Api\Data;

interface DownloadInterface
{
    /**
     * Constants for fields
     */
    const DOWNLOAD_ID = 'download_id';
    const TITLE  = 'title';
    const CONTENT = 'content';
    const CREATED_AT = 'created_at';
    const STATUS = 'status';
    /**#@-*/


    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get Content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get Status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set Title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Set Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * Set Created At
     *
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Set Status
     *
     * @param int status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);
}
