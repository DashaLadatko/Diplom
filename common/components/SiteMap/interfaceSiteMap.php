<?php

namespace common\components\SiteMap;

/**
 * Interface interfaceSiteMap
 */
interface interfaceSiteMap
{
    /**
     * It is used to get a reference to a resource
     * @return string
     *
     * public function getSiteMapUrl() {
     *      return Url::toRoute('/' . $this->alias);
     * }
     */
    public function getSiteMapUrl();

//    /**
//     * @return mixed
//     */
//    public function getSiteMapPriority();
//
//    /**
//     * @return mixed
//     */
//    public function getSiteMapChangeFreq();
}
