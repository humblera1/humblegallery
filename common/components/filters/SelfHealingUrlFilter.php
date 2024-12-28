<?php

namespace common\components\filters;

use common\components\interfaces\SelfHealingUrlHandlerInterface;
use common\components\urls\SelfHealingUrlHandler;
use Yii;
use yii\base\ActionFilter;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\di\NotInstantiableException;
use yii\web\NotFoundHttpException;

class SelfHealingUrlFilter extends ActionFilter
{
    public string $urlParamName = 'slug';

    public string|null $modelClass = null;

    public Model|null $model = null;

    private SelfHealingUrlHandlerInterface $handler;


    /**
     * @param $action
     * @return bool
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('You must specify the model class.');
        }

        $this->setHandler();

        $param = Yii::$app->request->get($this->urlParamName);
        $model = $this->modelClass::findOne($this->handler->getUniquePartFromUrl($param));

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        if ($model->slug !== $this->handler->getSlugPartFromUrl($param)) {
            $this->owner->redirect($model->getSelfHealingUrl(), 301);

            return false;
        }

        $this->model = $model;

        return parent::beforeAction($action);
    }

    /**
     * @return void
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    private function setHandler(): void
    {
        $handler = Yii::$container->has(SelfHealingUrlHandlerInterface::class)
            ? Yii::$container->get(SelfHealingUrlHandlerInterface::class)
            : new SelfHealingUrlHandler();

        if ($handler instanceof SelfHealingUrlHandlerInterface) {
            $this->handler = $handler;

            return;
        }

        throw new InvalidConfigException(sprintf("Handler must implement %s", SelfHealingUrlHandlerInterface::class));
    }
}
