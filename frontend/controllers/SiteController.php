<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Content;
use common\models\Partner;
use common\models\Category;
use common\traits\BaseFrontendAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    use BaseFrontendAction;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 5,//最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 2,//验证码字体大小，数值越小字体越大
                'height' => 40,
                'width' => 120,
                'offset' => 4,//设置字符偏移量
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $bannerModels = Content::find()->select(['id', 'title', 'thumb', 'url'])->where(['catid' => 20, 'status' => 99])->limit(5)->orderBy('sort ASC, id ASC')->asArray()->all();
        $newsModels = Content::find()->select(['id', 'title', 'description', 'url', 'created_at'])->where(['catid' => 5, 'status' => 99])->limit(5)->orderBy('sort DESC, id DESC')->asArray()->all();
        $typeModels = Category::find()->where(['parentid' => 2, 'ismenu' => 1])->orderBy('sort ASC, id ASC')->asArray()->all();
        $partnerModels = Partner::find()->where(['status' => Partner::STATUS_ACTIVE])->orderBy('sort DESC, id DESC')->asArray()->all();
        return $this->render('index', [
            'bannerModels' => $bannerModels,
            'newsModels' => $newsModels,
            'typeModels' => $typeModels,
            'partnerModels' => $partnerModels,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 1];
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $type = Yii::$app->request->get('type', 1);
        if ($type == 1) {
            $model->scenario = SignupForm::SCENARIO_STUDENT;
        } else {
            $model->scenario = SignupForm::SCENARIO_TEACHER;
        }
        $model->type = $type;
        
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->signup()) {
                return [
                    'url' => Yii::$app->getHomeUrl(),
                    'status' => 200,
                    'msg' => '恭喜你，账号注册成功！'
                ];
            } else {
                $tmp_error = $model->getFirstErrors();
                foreach($model->activeAttributes() as $error) {
                    if(isset( $tmp_error[$error]) && !empty($tmp_error[$error])){
                        return ['status' => 0, 'msg' => $tmp_error[$error]];
                    }
                }
            }
            
        }
        
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionSignup111()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                return $this->render('requestPasswordResetToken', [
                    'ispostemail' => 2,
                ]);
            } else {
                return $this->render('requestPasswordResetToken', [
                    'ispostemail' => 3,
                ]);
                //Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'ispostemail' => 1,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '新密码已设置成功。');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    
    public function actionWxjssdk()
    {
        \Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $url = Yii::$app->request->get('url', '');
        
        $appid = '';
        $appsecret = '';
        $jssdk = new \common\components\Wxjssdk($appid, $appsecret,urldecode($url));
        $signPackage = $jssdk->getSignPackage();
        return $signPackage;
        
    }
    
    public function actionOffline()
    {
        return $this->renderPartial('offline');
    }
}
