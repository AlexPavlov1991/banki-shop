<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\File;
use yii\data\Pagination;

class FileController extends Controller
{
    // запрос который выдает общее количество загруженных картинок {"total": 40}
    public function actionCount()
    {
        $result = ['total' => File::find()->count()];
        return json_encode($result);
    }

    // запрос с параметром указывающим запрошенную страницу в списке, возвращает список картинок по 10 штук на страницу {"page": 1, "list": [{"id": 10, "path": "image.jpg"}]}
    public function actionList()
    {
        $request = \Yii::$app->request;
        $page = $request->get('page') ?? 1;
        $query = File::find();
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 5,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
        $files = $query->offset($pages->offset)->limit($pages->limit)->all();
        $result = [
            'page' => $page,
            'list' => []
        ];
        foreach ($files as $file) {
            $result['list'][] = ['id' => $file->id, 'path' => $file->name];
        }
        return json_encode($result);
    }
    
    // запрос c параметром id который вернет данные картинки по id {"id": 10, "path": "image.jpg"}
    public function actionItem()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $file = File::findOne($id);
        $result = ['id' => $file->id, 'path' => $file->name];
        return json_encode($result);
    }
}