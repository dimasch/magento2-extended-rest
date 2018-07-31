<?php
/**
 * Copyright (c) 2018. Komplizierte Technologien. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace KT\RestApiSystem\Api;

interface CoreConfigManagementInterface
{
    /**
     * Retrieve list of all core config data
     *
     * @return mixed
     */
    public function getList();

    /**
     * Retrieve tree of all core config data
     *
     * @return mixed
     */
    public function getTree();

    /**
     * Retrieve config by key
     * @param string $key
     * @return mixed
     */
    public function getByKey($key);
}
