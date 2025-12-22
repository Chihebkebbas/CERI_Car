<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font.css',
        'css/acceuil.css',
        'css/auth.css',
        'css/reservation.css',
        'css/recherche.css',
        'css/voyage.css'
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
