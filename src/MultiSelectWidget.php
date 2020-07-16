<?php

namespace rootlocal\widgets\multiselect;

use Yii;
use dosamigos\multiselect\MultiSelectListBox;
use Exception;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class MultiSelectWidget
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\widgets\multiselect
 */
class MultiSelectWidget extends Widget
{
    /** @var array for generating the list options (value=>display) */
    public $selectableItems = [];
    /** @var array */
    public $selectedItems = [];
    /**
     * @var string|array the parameter to be used to generate a valid URL
     * @see Url::to
     */
    public $selectUrl;
    /**
     * @var string|array the parameter to be used to generate a valid URL
     * @see Url::to
     */
    public $deselectUrl;
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array the options for the Bootstrap Multiselect JS plugin.
     *            Please refer to the Bootstrap Multiselect plugin Web page for possible options.
     * @see http://davidstutz.github.io/bootstrap-multiselect/#options
     */
    public $clientOptions = [];


    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        if (!isset($this->options['multiple'])) {
            $this->options['multiple'] = 'multiple';
        }

        if ($this->selectUrl !== null) {
            $this->selectUrl = Url::to($this->selectUrl);
        }
        if ($this->deselectUrl !== null) {
            $this->deselectUrl = Url::to($this->deselectUrl);
        }

        $defaultClientOptions = [
            'includeSelectAllOption' => true,
            'numberDisplayed' => 2,
            'afterInit' => new JsExpression('function (ms) {
                var that = this,
                $selectableSearch = that.$selectableUl.next(),
                $selectionSearch = that.$selectionUl.next(),
                selectableSearchString = "#" + that.$container.attr("id") + " .ms-elem-selectable:not(.ms-selected)",
                selectionSearchString = "#" + that.$container.attr("id") + " .ms-elem-selection.ms-selected";
                
                that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on("keydown", function (e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });
    
                that.qs2 = $selectionSearch.quicksearch(selectionSearchString).on("keydown", function (e) {
                    if (e.which === 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
            }'),
            'afterSelect' => new JsExpression('function(value){
                var url = "' . $this->selectUrl . '";
                if(url.indexOf("?") === -1) {
                    url += "?item="+value;
                } else {
                    url += "&item="+value;
                }
            $.get(url, function(data, status){});}'),

            'afterDeselect' => new JsExpression('function(value){
                var url = "' . $this->deselectUrl . '";
                if(url.indexOf("?") === -1) {
                    url += "?item="+value;
                } else {
                    url += "&item="+value;
                }
            $.get(url, function(data, status){});}'),

            'selectableHeader' => '<div class="box-header">'
                . Yii::t('multiselect', 'Selectable Items') . '</div>',
            'selectionHeader' => '<div class="box-header">'
                . Yii::t('multiselect', 'Selected Items') . '</div>',

            'selectableFooter' => '<input type="text" class="search-input form-control" autocomplete="off" 
            placeholder="' . Yii::t('multiselect', 'Search') . '">',
            'selectionFooter' => '<input type="text" class="search-input form-control" autocomplete="off" 
            placeholder="' . Yii::t('multiselect', 'Search') . '">',

        ];

        $this->clientOptions = ArrayHelper::merge($defaultClientOptions, $this->clientOptions);

        $view = $this->getView();
        $this->registerAssets($view);
    }

    /**
     * @param View $view
     */
    protected function registerAssets(View $view)
    {
        MultiSelectAsset::register($view);
        QuicksearchAsset::register($view);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run()
    {
        $multiSelectListBox = MultiSelectListBox::widget([
            'id' => 'multi-select-list-' . $this->id,
            'name' => 'multi-select-list-' . $this->id,
            'data' => $this->selectableItems,
            'value' => $this->selectedItems,
            'options' => $this->options,
            'clientOptions' => $this->clientOptions
        ]);

        return Html::tag('div', $multiSelectListBox, [
            'class' => 'multi-select-widget'
        ]);
    }
}