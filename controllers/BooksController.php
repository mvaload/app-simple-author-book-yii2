<?php


namespace app\controllers;


use yii\rest\ActiveController;

class BooksController extends ActiveController
{
    public $modelClass = 'app\models\Book';
}