<?php
/* @var $this yii\web\View */
/* @var $booksList app\models\Book */

use yii\helpers\Url;

?>
<h1>Books</h1>
<br>
<a href="<?php echo Url::to(['book/create']); ?>" class="btn btn-primary">Create new book</a>
<br><br>

<table class="table table-condensed">
    <tr>
        <th>ID</th>
        <th>title</th>
        <th>image</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php foreach ($booksList as $book): ?>
        <tr>
            <td><?php echo $book->id;?></td>
            <td><?php echo $book->title;?></td>
            <td><?php echo $book->image;?></td>
            <td><a href="<?php echo Url::to(['book/update', 'id' => $book->id]); ?>">Edit</a></td>
            <td><a href="<?php echo Url::to(['book/delete', 'id' => $book->id]); ?>">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
