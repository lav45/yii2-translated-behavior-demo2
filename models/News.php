<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\validators\DateValidator;
use lav45\translate\TranslatedTrait;
use lav45\translate\TranslatedBehavior;
use lav45\behaviors\SerializeBehavior;
use lav45\behaviors\CorrectDateBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $_data тут будут хранится произвольные данные в json формате
 *
 * // Данные которые будут проксироваться CorrectDateBehavior => SerializeBehavior => News::$_data
 * @property string $publishDate
 *
 * // Данные которые будут проксироваться SerializeBehavior => News::$_data
 * @property int $publish_date
 *
 * Данные которые будут проксироваться в модель NewsLang
 * @property string $title
 * @property string $description
 * @property string $_meta_data
 * @property string $_data_lang => $_data
 *
 * // Данные которые будут проксироваться SerializeBehavior => TranslatedBehavior => NewsLang::$_meta_data
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 *
 * // Данные которые будут проксироваться SerializeBehavior => TranslatedBehavior => NewsLang::$_data
 * @property array $list
 *
 * @property NewsLang[] $newsLangs
 */
class News extends ActiveRecord
{
    use TranslatedTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],

            [['description'], 'string'],

            [['meta_title', 'meta_keyword', 'meta_description'], 'string'],

            [['list'], 'filter', 'filter' => 'array_filter'],

            [['publishDate'], 'date', 'type' => DateValidator::TYPE_DATETIME],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TranslatedBehavior::class,
                'translateRelation' => 'newsLangs',
                'translateAttributes' => [
                    'title',
                    'description',
                    '_meta_data',
                    '_data_lang' => '_data',
                    // т.к. в текущей модели еже есть поле _data то для этого поля нужна придумать алис
                    // тогда при записи данных в News::$_data_lang => NewsLang::$_data
                ]
            ],
            [
                'class' => CorrectDateBehavior::class,
                'attributes' => [
                    'publishDate' => 'publish_date',
                ],
            ],
            [
                // Это расширение будет принимать данные записанные в атрибут News::$publish_date
                // и сохранять их в виде json в поле News::$_data
                'class' => SerializeBehavior::class,
                'storageAttribute' => '_data',
                'attributes' => [
                    'publish_date',
                ],
            ],
            [
                // Это расширение будет принимать данные записанные в атрибут News::$meta_title, News::$meta_keyword, News::$meta_description
                // и сохранять их в виде json в поле NewsLang::$_meta_data !!! Данные будут проксироваться с помощью TranslatedBehavior
                'class' => SerializeBehavior::class,
                'storageAttribute' => '_meta_data',
                'attributes' => [
                    'meta_title',
                    'meta_keyword',
                    'meta_description',
                ],
            ],
            [
                // Это расширение будет принимать данные записанные в атрибут News::$list
                // и сохранять их в виде json в поле NewsLang::$_data_lang !!! Данные будут проксироваться с помощью TranslatedBehavior
                'class' => SerializeBehavior::class,
                'storageAttribute' => '_data_lang',
                'attributes' => [
                    'list' => [],
                ],
            ],
            [
                'class' => TimestampBehavior::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created',
            'updated_at' => 'Updated',

            'title' => 'Title',
            'description' => 'Description',

            'publishDate' => 'Publish date',

            'meta_title' => 'Meta title',
            'meta_keyword' => 'Meta keywords',
            'meta_description' => 'Meta description',

            'list' => 'Text list',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsLangs()
    {
        return $this->hasMany(NewsLang::class, ['news_id' => 'id']);
    }
}
