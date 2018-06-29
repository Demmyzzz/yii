<?php
namespace frontend\controllers;

use backend\models\Banner;
//use backend\models\Callback;

use backend\models\News;
use backend\models\Partner;
use backend\models\Beforeafter;
use backend\models\Product;
use backend\models\Review;
use backend\models\Sale;
use backend\models\StaticTextPhoto;
use frontend\models\User;
use Yii;

use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\StaticTextItem;
//use yii\web\Response;
//use yii\widgets\ActiveForm;
//use backend\models\UserRole;
//use yii\bootstrap\Html;
use backend\models\StaticText;
use backend\models\Category;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout' , 'signup', 'login','request-password-reset','password-reset', 'confirmation'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login','request-password-reset','password-reset', 'confirmation'],
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
     * @inheritdoc
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

        $static = StaticText::findOne(1);
        if($static)
        {
            $static->fillMetaTags();
        }

        $banners = Banner::find()->where(['active'=>1])->andWhere(['not',['ext'=>null]])->orderBy(['pos'=>SORT_DESC])->all();

        $staticText = StaticTextItem::find()
            ->where(['id' => [StaticTextItem::ECO,
                StaticTextItem::WITHOUT_DESIGN,
                StaticTextItem::RANGE,
                StaticTextItem::DELIVERY,
                StaticTextItem::TEXT,
            ]])
            ->indexBy('id')
            ->all();


        $collections = Category::find()->where(['active' => 1])->orderBy(['pos'=>SORT_DESC])->limit(4)->all();
        $products = Product::find()->where(['on_main'=>1])->orderBy(['pos'=>SORT_DESC])->all();

        $news = News::find()->where(['active'=>1])->all();
        //        var_dump(Yii::$app->security->validatePassword('123456',Yii::$app->security->generatePasswordHash('123456'))); die;
//        $callback = new Callback();
//        $message = '';
//        if($callback->load(Yii::$app->request->post()) && $callback->save())
//        {
//            $message = "Спасибо , Мы с вами скоро свяжемся";
//            return $this->render('callback_form',compact('callback','message'));
//        }
//        else
        return $this->render('index',compact('callback','staticText','news','categories', 'banners', 'furniture','furniturePhotos','collections','products', 'reviews'));
    }

//    /**
//     * Logs in a user.
//     *
//     * @return mixed
//     */
//    public function actionLogin()
//    {
//        if(!Yii::$app->user->isGuest)
//        {
//            return $this->goHome();
//        }
//
//        $model = new \frontend\models\LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->redirect(Yii::$app->user->returnUrl);
//        } else {
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Signs user up.
//     *
//     * @return mixed
//     */
//    public function actionSignup()
//    {
////        $model = new FrontendUserSignupForm();
//        $model = new SignupForm();
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            if($model->status == UserRole::STATUS_ENTITY){
//                $model->scenario = SignupForm::SCENARIO_ENTITY;
//            }
//            return ActiveForm::validate($model);
//        }
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user = $model->signup()) {
////                if (Yii::$app->getUser()->login($user)) {
////                    return $this->goHome();
////                }
////                FrontendUser::login(ArrayHelper::toArray($user),3600 * 24 * 30);
//                return $this->render('confirm.php', compact('user'));
//            }
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }


 //   /**
 //    * Logs out the current user.
 //    *
 //    * @return mixed
 //    */
 //   public function actionLogout()
 //   {
 //       Yii::$app->user->logout();
//
 //       return $this->goHome();
 //   }
//
//
 //   /**
 //    * Displays contact page.
 //    *
 //    * @return mixed
 //    */
 //   public function actionContact()
 //   {
 //       $model = new ContactForm();
 //       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
 //           if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
 //               Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
 //           } else {
 //               Yii::$app->session->setFlash('error', 'There was an error sending email.');
 //           }
//
 //           return $this->refresh();
 //       } else {
 //           return $this->render('contact', [
 //               'model' => $model,
 //           ]);
 //       }
 //   }

//    /**
//     * Displays about page.
//     *
//     * @return mixed
//     */
//    public function actionAbout()
//    {
//        return $this->render('about');
//    }


  //  /**
  //   * Andrianov A.M.
  //   * подтверждение регистрации
  //   */
  //  public function actionConfirmation(){
  //      $code = trim(Html::decode(\Yii::$app->request->get('code')));
  //      $user=User::findOne(['code_signup'=>$code]);
  //      if($user){
  //          $user->activate = 1;
  //          $user->save(false);
  //          Yii::$app->getUser()->login($user, 24 * 3600);
  //          return $this->goHome();
  //      }
//
  //      echo 'error';
  //  }
//
  //  /**
  //   * Requests password reset.
  //   *
  //   * @return mixed
  //   */
  //  public function actionRequestPasswordReset()
  //  {
  //      $model = new PasswordResetRequestForm();
  //      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
  //          if ($model->sendEmail()) {
  //              Yii::$app->session->setFlash('success', 'Проверьте ваш почтовый адрес для дальнейших инструкций.');
//
  //              return $this->goHome();
  //          } else {
  //              Yii::$app->session->setFlash('error', 'Извините, но для данного адреса востоновлние не возможно');
  //          }
  //      }
//
  //      return $this->render('requestPasswordResetToken', [
  //          'model' => $model,
  //      ]);
  //  }
//
  //  /**
  //   * Resets password.
  //   *
  //   * @param string $token
  //   * @return mixed
  //   * @throws BadRequestHttpException
  //   */
  //  public function actionPasswordReset($token)
  //  {
  //      try {
  //          $model = new ResetPasswordForm($token);
  //      } catch (InvalidParamException $e) {
  //          throw new BadRequestHttpException($e->getMessage());
  //      }
//
  //      if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
  //          Yii::$app->session->setFlash('success', 'Новый пароль сохранен.');
//
  //          return $this->goHome();
  //      }
//
  //      return $this->render('resetPassword', [
  //          'model' => $model,
  //      ]);
  //  }
}
