<?php

namespace common\components\SiteMap;

use Yii;
use yii\web\Response;

/**
 * Class SiteMapGenerator
 * @package common\components\SiteMap
 *
 * @property string $content
 * @property string $host
 *
 *     # example
 *
 *     public function actionIndex(){
 *          $model = new SiteMap([
 *                  Page::find()->where(['deleted' => Page::DELETED_IN_ACTIVE])->all(),
 *                  Category::find()->where(['deleted' => Category::DELETED_IN_ACTIVE, 'enabled' =>  Category::ENABLED_ON])->all(),
 *                  Product::find()->where(['deleted' => Product::DELETED_IN_ACTIVE, 'enabled' => Product::ENABLED_ON])->all()
 *          ]);
 *
 *          // in view echo $model->getContent();
 *          return $this->renderPartial('index', ['model' => $model]);
 *     }
 *
 */
class SiteMap
{
    const ALWAYS = 'always';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const NEVER = 'never';

    const DEFAULT_PRIORITY = '0.5';
    const DEFAULT_CHANGE_FREG = 'daily';

    protected $models = [];

    public $xmLns = 'http://www.sitemaps.org/schemas/sitemap/0.9';
    public $version = '1.0';
    public $encoding = 'UTF-8';


    public function __construct($array)
    {
        // marge all Model
        $this->models = $this->margeModels($array);

        // select response format
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');
    }

    /**
     * Generates xml siteMap
     * @return string
     */
    public function getContent()
    {
        $content = '';
        if ($this->models) {
            $content .= "<?xml version=\"$this->version\" encoding=\"$this->encoding\" ?><urlset xmlns=\"$this->xmLns\">";
            foreach ($this->models as $item) {
                $url = htmlspecialchars($this->host . $item->siteMapUrl);

                $priority = (method_exists($item, 'siteMapPriority') && $item->siteMapPriority) ?
                    $item->siteMapPriority : self::DEFAULT_PRIORITY;

                $changeFreq = (method_exists($item, 'siteMapChangeFreq') && $item->siteMapChangeFreq) ?
                    $item->siteMapChangeFreq : self::DEFAULT_CHANGE_FREG;

                if ($url) {
                    $content .= "<url><loc>$url</loc><changefreq>$changeFreq</changefreq><priority>$priority</priority></url>";
                }
            }
            $content .= '</urlset>';
        }
        return $content;
    }


    protected function margeModels(array $array)
    {
        $r = [];
        foreach ($array as $item) {
            $r = array_merge($this->models, $item);
        }
        return $r;
    }

    protected function getHost()
    {
        return Yii::$app->request->hostInfo;
    }
}