<?php

namespace frontend\controllers;

use common\modules\artist\models\data\Artist;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'statistics' => $this->getStatistics(),
            'artistsDataProvider' => $this->getArtistsDataProvider(),
        ]);
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

    private function getStatistics(): array
    {
        return [
            [
                'title' => '167',
                'subtitle' => 'картин',
                'icon' => 'art',
            ],
            [
                'title' => '167',
                'subtitle' => 'картин',
                'icon' => 'art',
            ],
            [
                'title' => '167',
                'subtitle' => 'картин',
                'icon' => 'art',
            ],
            [
                'title' => '167',
                'subtitle' => 'картин',
                'icon' => 'art',
            ],
        ];
    }

    private function getArtistsDataProvider(int $limit = 3): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Artist::find()->with('paintings.movements')->limit($limit),
            'pagination' => false,
        ]);
    }
}
