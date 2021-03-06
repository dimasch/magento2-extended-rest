<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiSystem\Api\Data;

/**
 * @api
 */
interface UrlRewriteInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**#@+
     * Constants
     */
    const ID = "url_rewrite_id";
    const ENTITY_TYPE = "entity_type";
    const ENTITY_ID = "entity_id";
    const REQUEST_PATH = "request_path";
    const TARGET_PATH = "target_path";
    const REDIRECT_TYPE = "redirect_type";
    const STORE_ID = "store_id";
    const DESCRIPTION = "description";
    const IS_AUTOGENERATED = "is_autogenerated";
    const METADATA = "metadata";
    /**#@-*/

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getEntityType();

    /**
     * @param string $entityType
     * @return $this
     */
    public function setEntityType($entityType);

    /**
     * @return string|null
     */
    public function getEntityId();

    /**
     * @param string $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * @return string|null
     */
    public function getRequestPath();

    /**
     * @param string $requestPath
     * @return $this
     */
    public function setRequestPath($requestPath);

    /**
     * @return string|null
     */
    public function getTargetPath();

    /**
     * @param string $targetPath
     * @return $this
     */
    public function setTargetPath($targetPath);

    /**
     * @return string|null
     */
    public function getRedirectType();

    /**
     * @param string $redirectType
     * @return $this
     */
    public function setRedirectType($redirectType);

    /**
     * @return string|null
     */
    public function getStoreId();

    /**
     * @param string $storeId
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string|null
     */
    public function getIsAutogenerated();

    /**
     * @param string $isAutogenerated
     * @return $this
     */
    public function setIsAutogenerated($isAutogenerated);

    /**
     * @return string|null
     */
    public function getMetadata();

    /**
     * @param string $metadata
     * @return $this
     */
    public function setMetadata($metadata);
}