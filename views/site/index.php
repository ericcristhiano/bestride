<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<h1>Available Rides</h1>

<div class="feedback">
    <?php foreach (Yii::$app->session->getAllFlashes() as $k => $v): ?>
        <div class="alert alert-<?= $k ?>">
            <?= $v ?>
        </div>
    <?php endforeach ?>
</div>

<div class="row rides">
    <?php foreach ($rides as $ride): ?>
        <?php
            if ($ride->associatedUsers >= $ride->available_seats) continue;

            if (!Yii::$app->user->isGuest && $user->id == $ride->user_id) {
                continue;
            }
        ?>
        <!-- RIDE -->
        <div class="ride col-sm-3 col-lg-3 col-md-3" title="<?= $ride->more_information ?>">
            <div class="thumbnail">
                <div class="clearfix heading">
                    <img class="img-circle pull-left" src="<?= Yii::getAlias('@web') ?>/<?= yii\helpers\Html::encode($ride->user->avatar) ?>" alt="Avatar">
                    <strong class="date"><?= $ride->dateFormated ?></strong>
                </div>

                <div class="caption">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="h6">Origin</h4>
                            <strong class="text-uppercase"><?= str_replace(strtolower($q), '<span class="highlight">' . yii\helpers\Html::encode($q) . '</span>', yii\helpers\Html::encode(strtolower($ride->origin))) ?></strong>
                        </div>

                        <div class="pull-right text-right">
                            <h4 class="h6">Destination</h4>
                            <strong class="text-uppercase"><?= str_replace(strtolower($q), '<span class="highlight">' . yii\helpers\Html::encode($q) . '</span>', yii\helpers\Html::encode(strtolower($ride->destination))) ?></strong>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="pull-right text-right">
                            <h4 class="h6">U$ PRICE</h4>
                            <strong class="text-uppercase"><?= ($ride->price > 0 ? number_format($ride->price, 2, ',', '.') : 'FREE') ?></strong>
                        </div>
                        <div class="pull-left">
                            <h4 class="h6">Seats available</h4>
                            <strong class="text-uppercase"><?= $ride->available_seats ?></strong>
                        </div>
                    </div>
                    
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <?php if ($ride->isAssociated($user->id)): ?>
                            <button disabled href="<?= \yii\helpers\Url::to(['ride/associate', 'id' => $ride->id]) ?>" class="btn btn-primary btn-block btn-join text-uppercase">Joined</button>
                        <?php else: ?>
                            <button data-id="<?= $ride->id ?>" class="btn btn-primary btn-block btn-join text-uppercase">Join</button>
                        <?php endif ?>
                    <?php endif ?>
                </div>

                <div class="thumbnail-footer">
                    <small class="text-center help-block">Registered <?= $ride->createdAtFormated ?></small>
                    <small class="text-center help-block">by <?= yii\helpers\Html::encode($ride->user->name) ?></small>
                </div>
            </div>
        </div>
        <!-- END RIDE -->
    <?php endforeach ?>

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