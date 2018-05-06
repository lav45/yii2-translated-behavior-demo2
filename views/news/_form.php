<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\News
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget as Imperavi;
use unclead\multipleinput\MultipleInput;

?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publishDate')->input('datetime') ?>

    <?= $form->field($model, 'description')->widget(Imperavi::class) ?>

    <fieldset class="form-group">
        <legend><?= $model->getAttributeLabel('list') ?></legend>

        <?= $form->field($model, 'list')->widget(MultipleInput::class)->label(false); ?>

    </fieldset>

    <fieldset class="form-group">
        <legend>SEO</legend>

        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_keyword')->textarea(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

    </fieldset>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
