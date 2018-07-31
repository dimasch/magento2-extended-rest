<?php
/**
 *
 * Copyright © 13.03.2018 KT-TEAM, Inc. All rights reserved.
 * author: Yeroslaev V.
 */
namespace KT\RestApiCatalog\Api;

interface CategoryInformationInterface
{

    /**
     * @param int $id
     * @param string[] $eav
     * @return mixed[]
     */
    public function getInformation(
        $id,
        $eav =
        [
            'description'=>'',
            'image'=>'',
            'svg_image'=>'',
            'url_key'=>'',
            'is_active_brand'=>'',
            'include_in_menu'=>'',
            'meta_title'=>'',
            'meta_keywords'=>'',
            'meta_description'=>''
        ]
    );
}