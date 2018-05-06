<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_lang".
 *
 * @property int $news_id
 * @property string $lang_id
 * @property string $title
 * @property string $description
 * @property string $meta_data
 * @property string $_data
 *
 * @property News $news
 */
class NewsLang extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'description' => 'Description',
            'meta_data' => 'Meta Data',
            '_data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }
}
