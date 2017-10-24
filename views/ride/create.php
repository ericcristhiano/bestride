<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ride */

$this->title = 'New Ride';
$this->params['breadcrumbs'][] = ['label' => 'Rides', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ride-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
