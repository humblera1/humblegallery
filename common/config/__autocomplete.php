<?php

use common\modules\user\models\data\User;
use yii\rbac\DbManager;


/**
 * This class only exists here for IDE (PHPStorm/Netbeans/...) autocompletion.
 * This file is never included anywhere.
 * Adjust this file to match classes configured in your application config, to enable IDE autocompletion for custom components.
 */
class Yii
{
    public static __Application $app;
}

/**
 * @property DbManager $authManager
 * @property __WebUser $user
 */
class __Application {}

/**
 * @property User $identity
 */
class __WebUser {
}
