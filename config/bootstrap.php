<?php

Yii::$container->set('lav45\translate\TranslatedBehavior', [
    'primaryLanguage' => function($lang_id) {
        $locales = array_flip(Yii::$app->params['langLocaleList']);
        return $locales[$lang_id];
    }
]);

Yii::$container->set('yii\bootstrap\ActiveForm', [
    'validateOnBlur' => false,
    'validateOnChange' => false,
    'options' => [
        'autocomplete' => 'off'
    ],
    'layout' => 'horizontal',
]);

Yii::$container->set('vova07\imperavi\Widget', [
    'settings' => [
        'minHeight' => 200,
        'buttonSource' => true,
        'replaceDivs' => false,
        'toolbarFixed' => false,
        'plugins' => [
            'table',
            'video',
            'fontsize',
            'fullscreen',
            'definedlinks',
        ],
    ],
    'options' => [
        'style' => 'display: none;'
    ],
]);
