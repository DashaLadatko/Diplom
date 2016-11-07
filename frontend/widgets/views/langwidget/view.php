<?php

use yii\helpers\Html;

?>

<div id="navr" class="lang">
    <div class="lang-wrapper">
        <div class="md-fab-actions">
            <?php
            $request_without_lang_url = Yii::$app->getRequest()->getLangUrl();
            ?>
            <?php foreach ($langs as $lang): ?>
                <? $link = '';

                $baseUrl = Yii::$app->urlManager->getBaseUrl();
                if (strlen($baseUrl) > 0 && strpos($request_without_lang_url, $baseUrl) === 0) {
                    $link = $baseUrl . '/' . $lang->url . substr($request_without_lang_url, strlen($baseUrl));
                } else {
                    $link = '/' . $lang->url . $request_without_lang_url;
                }
                echo '<a href="'.$link.'"><img class="lang-item lang-'.$lang->url.'" src="'.$baseUrl.'/img/lang/'.$lang->url.'.png" alt="language"></a>';
                //'/' . $lang->url . Yii::$app->getRequest()->getLangUrl()?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!--//Html::img('/images/loc/'.$lang->local.'.png',['alt' => $lang->name])-->
<!--    </div>-->
<!--</div>-->
