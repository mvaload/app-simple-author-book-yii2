<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books_to_authors".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $author_id
 */
class BookToAuthor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books_to_authors';
    }

}
