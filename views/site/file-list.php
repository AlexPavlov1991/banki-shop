<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use coderius\lightbox2\Lightbox2;
// use yii\imagine\Image;

$this->title = 'File list';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= coderius\lightbox2\Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 100,
        'wrapAround' => true,
        
    ]
]); ?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($files)): ?>
        <?= $sort->link('name') . ' | ' . $sort->link('created_at') ?>
        <table class="table">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Created at</th>
        </tr>
            <?php foreach($files as $file): ?>
                <tr>
                    <td>
                        <?= $file->id ?>
                    </td>
                    <td>
                        <?= $file->name ?>
                    </td>
                    <td>
                        <a href="<?= Yii::getAlias('@web/uploads/' . $file->name, ['alt' => $file->name]) ?>" data-lightbox="image-<?= $file->id ?>" data-title="<?= $file->name ?>" data-alt="<?= $file->name ?>">
                            <?= Html::img('@web/uploads/thumbs/' . $file->name, ['alt' => $file->name, 'width' => 100]) ?>
                        </a>
                    </td>
                    <td>
                        <?= $file->created_at ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?= LinkPager::widget(['pagination' => $pages]) ?>
    <?php else: ?>
        empty
    <?php endif; ?>
</div>