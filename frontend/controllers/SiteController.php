<?php

namespace frontend\controllers;

use common\modules\artist\models\data\Artist;
use common\modules\movement\models\data\Movement;
use common\modules\painting\models\data\Painting;
use common\modules\subject\models\data\Subject;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
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
            'paintingsDataProvider' => $this->getPaintingsDataProvider(),
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
        $cache = Yii::$app->cache;
        $cacheKey = 'appStatistics';

        $statistics = $cache->get($cacheKey);

        if ($statistics === false) {
            $paintingsAmount = Painting::find()->count();
            $artistsAmount = Artist::find()->count();
            $subjectsAmount = Subject::find()->count();
            $movementsAmount = Movement::find()->count();

            $statistics = [
                [
                    'title' => $this->formatNumber($paintingsAmount),
                    'subtitle' => 'картин',
                    'icon' => 'art',
                ],
                [
                    'title' => $this->formatNumber($artistsAmount),
                    'subtitle' => 'художников',
                    'icon' => 'palette',
                ],
                [
                    'title' => $this->formatNumber($subjectsAmount),
                    'subtitle' => 'жанров',
                    'icon' => 'mountains',
                ],
                [
                    'title' => $this->formatNumber($movementsAmount),
                    'subtitle' => 'направлений',
                    'icon' => 'monument',
                ],
            ];

            $cache->set($cacheKey, $statistics, 24 * 60 * 60);
        }

        return $statistics;
    }

    private function getArtistsDataProvider(int $limit = 3): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Artist::find()
                ->with('paintings.movements')
                ->orderBy(new Expression('RAND()'))
                ->limit($limit),
            'pagination' => false,
        ]);
    }

    private function getPaintingsDataProvider(int $limit = 15): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Painting::find()
                ->orderBy(new Expression('RAND()'))
                ->limit($limit),
            'pagination' => false,
        ]);
    }

    private function formatNumber(int $number): string
    {
        if ($number < 10) {
            return '10+';
        }

        $magnitude = pow(10, floor(log10($number)));
        $rounded = floor($number / $magnitude) * $magnitude;

        return $rounded . '+';
    }
}
