<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '修改资料';
?>
<div class="container my-5">
	<div class="row">
		<div class="col-md-3">
		<?= $this->render('_left') ?>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="headline d-flex justify-content-between">
						<h4 class="head-title">修改密码</h4>
					</div>
					<div class="mt-4">
					<?php $form = ActiveForm::begin(['id' => 'form-changepwd', 'enableClientScript' => false,]); ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'password_new')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                
                    <div class="form-group d-flex justify-content-center">
                        <div class="col-md-3"><?= Html::submitButton('确认修改', ['class' => 'btn btn-primary btn-block']) ?></div>
                    </div>
                <?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>