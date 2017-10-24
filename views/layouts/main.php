<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$model = new \app\models\LoginForm();

if ($model->load(Yii::$app->request->post()) && $model->login()) {
    $controller = new yii\web\Controller('1', 'c');
    $controller->redirect(['site/index']);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Bestride</title>
    <?php $this->head() ?>
    
    <?php if (Yii::$app->session->get('theme') == 'new'): ?>
        <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/new-theme.css"/>
    <?php endif ?>
</head>
<body>
<?php $this->beginBody() ?>
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= \yii\helpers\Url::to(['site/index']) ?>"><img src="<?= Yii::getAlias('@web') ?>/img/BestRide_logo.png" alt="BestRide Logo"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-left" method="get" action="<?= \yii\helpers\Url::to(['site/search']) ?>">
                    <h2 class="h4">Find your ride</h2>
                    <div class="form-group">
                        <input name="q" type="text" class="form-control" placeholder="Search">
                    </div>
                    <select class="form-control" name="order">
                        <option value="date">Registration date</option>
                        <option value="lower-price">Lower Price</option>
                        <option value="highest-price">Highest Price</option>
                    </select>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>

                <?php if (Yii::$app->user->isGuest): ?>
                    <?php
                        $form = ActiveForm::begin([
                            'options' => [
                                'class' => 'navbar-right'
                            ],
                        ]);
                    ?>
                        <div class="heading-links">
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="login" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        Login
                                    </a>

                                    <ul class="dropdown-menu dropdown-login">
                                        <li>
                                            <?= $form->field($model, 'username')->textInput(['placeholder' => 'E-mail'])->label(false) ?>
                                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
                                            
                                            <input type="submit" class="btn btn-default" value="OK" />
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="<?= \yii\helpers\Url::to(['user/create']) ?>" class="btn">Register</a>
                                </li>
                            </ul>

                        </div>
                    <?php ActiveForm::end(); ?>
            <?php else: ?>
                <form class="navbar-right">
                    <div class="heading-links pull-left">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <img class="img-circle" src="<?= Yii::getAlias('@web') ?>/<?= Html::encode(Yii::$app->user->identity->avatar) ?>" alt="Avatar" />
                                    My Profile <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="<?= \yii\helpers\Url::to(['ride/manage']) ?>">Manage Rides</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Update profile information</a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['site/logout']) ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </form>
            <?php endif ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= $content ?>
            </div>
        </div>
    </div>
    
    
    <div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog">
        <input id="ride-id" type="hidden" />
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Association confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Confirm your association with this ride?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" data-dismiss="modal" data-yes class="btn btn-primary">Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <footer class="footer">
        <div class="container">
            <span>© BestRide 2017</span>
            <div class="pull-right theme-choice">
                <a href="<?= \yii\helpers\Url::to(['site/new-theme']) ?>" class="btn btn-default pull-right">New Theme</a>
                <a href="<?= \yii\helpers\Url::to(['site/default-theme']) ?>" class="btn btn-default pull-right">Default Theme</a>
            </div>
        </div>
    </footer>

    <script>
        var BASE_URL = "<?= \yii\helpers\Url::to(['/'], true); ?>";
        <?php if (!Yii::$app->user->isGuest): ?>
            var USER_ID = "<?= Yii::$app->user->identity->id ?>";
        <?php endif ?>
    </script>
    
    <?php $this->endBody() ?>
    <script src="<?= Yii::getAlias('@web') ?>/js/bootstrap.js"></script>
</body>
</html>
<?php $this->endPage() ?>
