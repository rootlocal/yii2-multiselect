<?php

namespace rootlocal\widgets\multiselect;

use yii\web\AssetBundle;

/**
 * Class MultiSelectAsset
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\widgets\multiselect
 */
class MultiSelectAsset extends AssetBundle
{
    /** @var array */
    public $css = ['css/multiselect.css',];
    /** @var array */
    public $js = [];
    /** @var array */
    public $depends = [];


    /** {@inheritdoc}*/
    public function init()
    {
        parent::init();
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }
}