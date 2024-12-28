<?php

namespace common\components\behaviors;

use common\components\interfaces\SelfHealingUrlHandlerInterface;
use common\components\urls\SelfHealingUrlHandler;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;

class SelfHealingUrlBehavior extends Behavior
{
    public string|null $identifierAttribute = null;

    public string $slugAttribute = 'slug';

    private SelfHealingUrlHandlerInterface $handler;

    /**
     * @param $owner
     * @return void
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function attach($owner): void
    {
        parent::attach($owner);

        if ($this->identifierAttribute === null) {
            $this->identifierAttribute = $this->owner->primaryKey()[0];
        }

        $this->setHandler();
    }

    /**
     * @return string
     */
    public function getSelfHealingUrl(): string
    {
        return $this->handler->generateSelfHealingUrl($this->owner->{$this->slugAttribute}, $this->owner->{$this->identifierAttribute});
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
