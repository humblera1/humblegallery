<?php

namespace common\modules\user\controllers\frontend;

use common\modules\collection\models\data\Collection;
use common\modules\user\models\data\User;
use common\modules\user\models\enums\ProfileSectionsEnum;
use common\modules\user\models\forms\EditForm;
use common\modules\user\models\forms\LoginForm;
use common\modules\user\models\forms\SignupForm;
use common\modules\user\models\search\FavoritePaintingSearch;
use common\modules\user\models\search\UserCollectionSearch;
//use common\modules\user\models\search\UserFavoritesSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{
    public $layout = 'profile';

    protected ?User $currentUser = null;

    /**
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $username = $this->request->get('username');

        if ($username !== null) {
            $this->currentUser = User::findOne(['username' => $username]);

            if ($this->currentUser === null) {
                throw new NotFoundHttpException('User not found.');
            }
        }

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'only' => ['personal-area'],
//                'rules' => [
//                    [
//                        'actions' => ['personal-area'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//                'denyCallback' => function ($rule, $action) {
//                    $cache = Yii::$app->cache;
//                    $cache->set('needToShowLoginModal', true, 10);
//
//                    return $this->redirect('/');
//                },
//            ],
        ];
    }

    public function actionView(string $username): string
    {
        return $this->render('view', [
            'user' => $this->currentUser,
        ]);
    }

    public function actionFavorites(): string
    {
        return $this->render('favorites', [
            'user' => $this->currentUser,
        ]);
    }

    public function actionCollections(): string
    {
        return $this->render('collections', [
            'user' => $this->currentUser,
        ]);
    }

    public function actionCollectionView(): string
    {
        return $this->render('collection-view', [
            'user' => $this->currentUser,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findUser(string $username): User
    {
        $user = User::findOne(['username' => $username]);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return $user;
    }


//    /**
//     * @throws NotFoundHttpException
//     */
//    public function actionProfile($section): string
//    {
//        if (!in_array($section, ProfileSectionsEnum::getLabels())) {
//            throw new NotFoundHttpException();
//        }
//
//        if ($this->request->isAjax) {
//            return match ($section)  {
//                'info' => $this->getInfo(),
//                'collections' => $this->getCollections(),
//                'courses' => $this->getCourses(),
//                'favorites' => $this->getFavorites(),
//                'settings' => $this->getSettings(),
//                default => throw new NotFoundHttpException('Not found section ' . $section),
//
//            };
//        }
//
//        return $this->render('sections/info');
//    }
//
//    protected function getInfo(): string
//    {
//        return $this->renderPartial('sections/info');
//    }
//
//    public function getCollections(): string
//    {
//        $model = new Collection();
//
//        if ($model->load($this->request->post())) {
//            $model->user_id = Yii::$app->user->id;
//
//            $model->save();
//        }
//
//        $searchModel = new UserCollectionSearch();
//
//        $dataProvider = $searchModel->search($this->request->post());
//
//        return $this->renderAjax('sections/collections', [
//            'model' => $model,
//            'searchModel' => $searchModel,
//            'provider' => $dataProvider,
//        ]);
//    }
//
//    protected function getCourses()
//    {
//        return $this->renderPartial('sections/courses');
//    }
//
//
//    protected function getFavorites(): string
//    {
//        $searchModel = new FavoritePaintingSearch();
//        $dataProvider = $searchModel->search($this->request->post());
//
//        return $this->renderAjax('sections/favorites', [
//            'model' => $searchModel,
//            'provider' => $dataProvider,
//        ]);
//    }
//
//    protected function getSettings()
//    {
//        return $this->renderPartial('sections/settings');
//    }
}