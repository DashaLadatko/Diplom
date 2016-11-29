<?php
/**
 * Created by PhpStorm.
 * User: Dasha
 * Date: 025 25.11.16
 * Time: 0:02
 */
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->getFullName();

?>


      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?= $model->getFullName()?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive"> </div>

                <div class=" col-md-9 col-lg-9 ">
                  <table class="table table-user-information">
                    <tbody>

                    <tr>
                        <td>Прізвище</td>
                        <td><?= $model->last_name?></td>
                    </tr>

                      <tr>
                        <td>Ім'я</td>
                        <td><?= $model->first_name?></td>
                      </tr>

                      <tr>
                          <td>По-батькові</td>
                          <td><?= $model->second_name?></td>
                      </tr>

                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:info@support.com"><?= $model->email?></a></td>
<!--                      </tr>-->
<!--                        <td>Phone Number</td>-->
<!--                        <td>123-4567-890(Landline)<br><br>555-4567-890(Mobile)-->
<!--</td>-->
<!---->
<!--                      </tr>-->
                      <tr>
                          <td>Роль:</td>
                          <td><?= $model->roleName()?></td>
                      </tr>

                    </tbody>
                  </table>

                  <a href="<?= \yii\helpers\Url::toRoute(['user/changepassword', 'id' => Yii::$app->user->id])?>" class="btn btn-primary">Змінити пароль</a>
<!--                  <a href="" class="btn btn-primary">Team Sales Performance</a>-->
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="<?= \yii\helpers\Url::toRoute(['user/update', 'id' => Yii::$app->user->id])?>" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
<!--                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>-->
                        </span>
                    </div>

          </div>
        </div>
      </div>
    </div>

