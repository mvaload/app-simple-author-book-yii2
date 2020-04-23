<?php

/* @var $this yii\web\View */
/* @var $booksList app\models\Book */

$this->title = 'My Yii Application';

?>

<?php foreach($booksList as $book): ?>
    <h3><?php echo $book->title; ?></h3>
    <hr>
    <?php foreach($book->getAuthors() as $author): ?>
        <?php echo $author->first_name. ' ' .$author->last_name; ?>
    <?php endforeach; ?>
<?php endforeach; ?>


<!--<div class="site-index">-->
<!--    <div class="jumbotron"></div>-->
<!--</div>-->
