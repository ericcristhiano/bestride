<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ride */

$this->title = 'Create Ride';
$this->params['breadcrumbs'][] = ['label' => 'Rides', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="pull-left">My Rides</h1>

<a href="<?= \yii\helpers\Url::to(['ride/create']) ?>" class="btn btn-primary pull-right">New Ride</a>

<div class="clearfix"></div>

<?php foreach (Yii::$app->session->getAllFlashes() as $k => $v): ?>
    <div class="alert alert-<?= $k ?>">
        <?= $v ?>
    </div>
<?php endforeach ?>

<table class="table table-rides text-center">
    <thead>
        <tr>
            <th>Date of Ride</th>
            <th>Date of Registration</th>
            <th>Origin</th>
            <th>Destination</th>
            <th>Price</th>
            <th>Number of seats</th>
            <th>Associated Users</th>
            <th>Used Places</th>
            <th>Value Received</th>
            <th>More Information</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($rides as $ride): ?>
            <tr>
                <td><?= Html::encode($ride->dateFormated) ?></td>
                <td><?= Html::encode($ride->createdAtFormated) ?></td>
                <td><?= Html::encode($ride->origin) ?></td>
                <td><?= Html::encode($ride->destination) ?></td>
                <td><?= Html::encode($ride->price) ?></td>
                <td><?= Html::encode($ride->available_seats) ?></td>
                <td><?= Html::encode($ride->associatedUsers) ?></td>
                <td><?= Html::encode($ride->usedPlaces) ?>%</td>
                <td><?= Html::encode($ride->valueReceived) ?></td>
                <td><button data-status="closed" class="btn btn-default btn-more-info" data-id="<?= $ride->id ?>"><span class="glyphicon glyphicon-plus"></span> More info</button></td>
                <tr class="more-info-content">
                    <td colspan="10">
                        <div class="associated-users">
                            <h3 class="text-left">Associated Users</h3>
                            <div class="row">
                                <?php foreach ($ride->users as $user): ?>
                                    <div class="col-sm-2 col-lg-2 col-md-2">
                                        <div class="thumbnail">
                                            <div class="clearfix heading text-center">
                                                <img class="img-circle" src="<?= Yii::getAlias('@web') ?>/<?= Html::encode($user->avatar) ?>" alt="Avatar">
                                            </div>

                                            <div class="thumbnail-footer">
                                                <small class="text-center help-block"><?= Html::encode($user->name) ?></small>
                                                <small class="text-center help-block"><?= Html::encode($user->email) ?></small>
                                                <small class="text-center help-block"><?= Html::encode($user->age) ?> years old</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            
        <?php endforeach ?>
    </tbody>
</table>

<hr />

<h1>My Associated Rides</h1>
<div class="row rides">
    <?php foreach ($associatedRides as $associatedRide): ?>
        <!-- RIDE -->
        <div class="col-sm-3 col-lg-3 col-md-3">
            <div class="thumbnail">
                <div class="clearfix heading">
                    <img class="img-circle pull-left" src="<?= Yii::getAlias('@web') ?>/<?= Html::encode($associatedRide->user->avatar) ?>" alt="Avatar">
                    <strong class="date"><?= Html::encode($associatedRide->dateFormated) ?></strong>
                </div>

                <div class="caption">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="h6">Origin</h4>
                            <strong class="text-uppercase"><?= Html::encode($associatedRide->origin) ?></strong>
                        </div>

                        <div class="pull-right text-right">
                            <h4 class="h6">Destination</h4>
                            <strong class="text-uppercase"><?= Html::encode($associatedRide->destination) ?></strong>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="pull-right text-right">
                            <h4 class="h6">U$ PRICE</h4>
                            <strong class="text-uppercase"><?= ($associatedRide->price > 0 ? number_format($associatedRide->price, 2, ',', '.') : 'FREE') ?></strong>
                        </div>
                        <div class="pull-left">
                            <h4 class="h6">Seats available</h4>
                            <strong class="text-uppercase"><?= $associatedRide->available_seats ?></strong>
                        </div>
                    </div>

                    <a href="<?= \yii\helpers\Url::to(['ride/delete', 'id' => $associatedRide->id]) ?>" class="btn btn-danger btn-block btn-delete text-uppercase">Delete</a>
                </div>

                <div class="thumbnail-footer">
                    <small class="text-center help-block">Associated in <?= $associatedRide->getDate(Yii::$app->user->identity->id) ?></small>
                    <small class="text-center help-block">Owner: <?= Html::encode($associatedRide->user->name) ?></small>
                    <small class="text-center help-block">E-mail: <?= Html::encode($associatedRide->user->email) ?></small>
                </div>
            </div>
        </div>
        <!-- END RIDE -->
    <?php endforeach; ?>

    <div class="col-md-12 text-center">
        <ul class="pagination">
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
        </ul>
    </div>
</div>