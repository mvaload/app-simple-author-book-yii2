<?php
/* @var $this yii\web\View */
/* @var $model app\models\Book */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h1>Create new book</h1>

<?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'title'); ?>
    <?php echo $form->field($model, 'image'); ?>
    <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>


