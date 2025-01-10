<?php

namespace common\components;

use Yii;
use yii\web\Controller as BaseWebController;
use yii\web\Response;

class FrontendController extends BaseWebController
{
    protected function successResponse($message = 'Success'): array
    {
        $this->response->format = Response::FORMAT_JSON;

        return [
            'success' => true,
            'message' => $message,
        ];
    }

    protected function errorResponse($message = 'Error'): array
    {
        $this->response->format = Response::FORMAT_JSON;

        return [
            'success' => false,
            'message' => $message,
        ];
    }
}