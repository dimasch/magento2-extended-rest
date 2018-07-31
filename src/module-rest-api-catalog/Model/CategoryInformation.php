<?php
/**
 * Copyright © KT-TEAM. All rights reserved.
 * author: Yeroslaev V.
 * 13.03.2018
 */
namespace KT\RestApiCatalog\Model;

use Magento\Framework\Api\AttributeValueFactory;

class CategoryInformation extends \Magento\Catalog\Model\Category
{

    const CATEGORY_ENTITY_TYPE_ID = 3;

    protected function getEavAttribute($eav_array,$key,$attribute)
    {
        foreach($eav_array as $eav){
            if($eav['attribute_code'] == $key){
                return $eav[$attribute];
            }
        }
    }

    protected function bindJoin($tbl,$key)
    {
        return 'ccet.entity_id = ' . $tbl . '.entity_id AND ' . $tbl . '.attribute_id = :' . $key;
    }

    protected function prepareForReturn($data,$key,$eav_results)
    {
        $eq_attribute = $this->getEavAttribute($eav_results,$key,'frontend_input');
        if($eq_attribute == 'boolean' || $eq_attribute == 'select'){
            return ($data == null || $data == 0 || $data == '') ? false : true;
        } else {
            return ($data == null || $data == '') ? '' : $data;
        }
    }

    public function getInformation(
        $id,
        $eav =
        [
            'description'=>'',
            'image'=>'',
            'svg_image'=>'',
            'url_key'=>'',
            'is_active_brand' => '',
            'include_in_menu',
            'meta_title'=>'',
            'meta_keywords'=>'',
            'meta_description'=>''
        ]
    )
    {
        $eav_keys = $eav;
        $array_keys = array_keys($eav);
        $res = $this->_getResource();
        $connector = $res->getConnection();
        $array_keys_in = '(' . "'" . implode("','",$array_keys) . "'" . ')';
        $select_eav = $connector->select()
            ->from(['ea' => $res->getTable('eav_attribute')])
            ->where('ea.attribute_code in ' . $array_keys_in)
        ->where('ea.entity_type_id = ' . self::CATEGORY_ENTITY_TYPE_ID);
        $eav_results = $connector->fetchAll($select_eav);
        foreach($eav as $key=>&$e){
            $e = $this->getEavAttribute($eav_results,$key,'attribute_id');
        }
        $bind_join_ccev = $this->bindJoin('ccev',$array_keys[1]);
        $bind_join_ccet = $this->bindJoin('ccet_dob',$array_keys[2]);
        $bind_join_url = $this->bindJoin('url',$array_keys[3]);
        $bind_join_ccei = $this->bindJoin('ccei',$array_keys[4]);
        $bind_join_menu = $this->bindJoin('menu',$array_keys[5]);
        $bind_join_mtitle = $this->bindJoin('mtitle',$array_keys[6]);
        $bind_join_mkey = $this->bindJoin('mkey',$array_keys[7]);
        $bind_join_mdesc = $this->bindJoin('mdesc',$array_keys[8]);
        $select = $connector->select()
            ->from(
                ['ccet' => $res->getTable('catalog_category_entity_text')],
                ['value as description'])
            ->joinLeft(
                ['ccev' => $res->getTable('catalog_category_entity_varchar')],
                $bind_join_ccev,['value as image']
            )
            ->joinLeft(
                ['ccet_dob' => $res->getTable('catalog_category_entity_text')],
                $bind_join_ccet,['value as svg_image']
            )
            ->joinLeft(
                ['url' => $res->getTable('catalog_category_entity_varchar')],
                $bind_join_url,['value as url_key']
            )
            ->joinLeft(
                ['ccei' => $res->getTable('catalog_category_entity_int')],
                $bind_join_ccei,['value as is_active_brand']
            )
            ->joinLeft(
                ['menu' => $res->getTable('catalog_category_entity_int')],
                $bind_join_menu,['value as include_in_menu']
            )
            ->joinLeft(
                ['mtitle' => $res->getTable('catalog_category_entity_varchar')],
                $bind_join_mtitle,['value as meta_title']
            )
            ->joinLeft(
                ['mkey' => $res->getTable('catalog_category_entity_text')],
                $bind_join_mkey,['value as meta_keywords']
            )
            ->joinLeft(
                ['mdesc' => $res->getTable('catalog_category_entity_text')],
                $bind_join_mdesc,['value as meta_description']
            )
            ->where(
                'ccet.entity_id = :category_id'
            )
            ->where(
                'ccet.attribute_id is null OR ccet.attribute_id = :' . $array_keys[0]
            )
        ->limit(1);
        $eav_query = $eav;
        $eav_query['category_id'] = $id;
        $result_query = $connector->fetchAll($select, $eav_query);
        if($result_query == null){
            $result_query[] = $eav_keys;
        }
        $result = array_merge($eav_keys, $result_query[0]);
        foreach($result as $key=>&$res){
            $res = $this->prepareForReturn($res,$key,$eav_results);
        }
        $result['seo_url_key'] = $result['url_key'];
        return array($result);
    }
}