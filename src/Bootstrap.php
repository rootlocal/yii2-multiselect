<?php

namespace rootlocal\widgets\multiselect;

use yii\base\BootstrapInterface;
use yii\base\Application;
use yii\i18n\PhpMessageSource;

/**
 * Class Bootstrap Application bootstrap process
 *
 * @see \yii\base\BootstrapInterface
 *
 * @author Alexander Zakharov <sys@eml.ru>
 * @package rootlocal\widgets\multiselect
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        // add module I18N category
        if (!isset($app->i18n->translations['multiselect'])) {
            $app->i18n->translations['multiselect'] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}