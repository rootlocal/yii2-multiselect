<?php

namespace rootlocal\widgets\multiselect;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class QuicksearchAsset
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\widgets\multiselect
 */
class QuicksearchAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@bower/quicksearch/dist';
    /** @var string[] */
    public $js = ['jquery.quicksearch.' . (YII_DEBUG ? 'min' : '') . '.js'];
    /** @var array */
    public $css = [];
    /** @var string[] */
    public $depends = [
        JqueryAsset::class,
    ];
}