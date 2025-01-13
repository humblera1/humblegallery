<?php

namespace common\components\filters;

use Closure;
use common\components\interfaces\SelfHealingUrlHandlerInterface;
use common\components\urls\SelfHealingUrlHandler;
use Yii;
use yii\base\ActionFilter;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\di\NotInstantiableException;
use yii\web\NotFoundHttpException;

class SelfHealingUrlFilter extends ActionFilter
{
    public string $urlParamName = 'slug';

    public string|null $modelClass = null;

    public Model|null $model = null;

    public array|Closure $queryConstraints = [];

    private SelfHealingUrlHandlerInterface $handler;

    private ?string $param = null;

    /**
     * @param $action
     * @return bool
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action): bool
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('You must specify the model class.');
        }

        $this->setParam();
        $this->setHandler();

        $model = $this->getModelInstance();

        if ($model->slug !== $this->handler->getSlugPartFromUrl($this->param)) {
            $this->owner->redirect($model->getSelfHealingUrl(), 301);

            return false;
        }

        $this->model = $model;

        return parent::beforeAction($action);
    }

    /**
     * @return Model
     * @throws NotFoundHttpException
     */
    protected function getModelInstance(): Model
    {
        $pkName = $this->modelClass::primaryKey()[0];
        $query = $this->modelClass::find()->where([$pkName => $this->handler->getUniquePartFromUrl($this->param)]);

        if (is_callable($this->queryConstraints)) {
            call_user_func($this->queryConstraints, $query);
        } elseif (is_array($this->queryConstraints)) {
            $query->andWhere($this->queryConstraints);
        }

        $model = $query->one();

        if ($model === null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    /**
     * @throws InvalidConfigException
     */
    protected function setParam(): void
    {
        $this->param = Yii::$app->request->get($this->urlParamName);

        if (!$this->param) {
            throw new InvalidConfigException('The URL parameter "%s" is required.', $this->urlParamName);
        }
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
