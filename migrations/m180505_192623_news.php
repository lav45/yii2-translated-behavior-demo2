<?php

use lav45\db\Migration;

/**
 * Class m180505_192623_news
 */
class m180505_192623_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            '_data' => $this->text(),
        ]);

        $this->createTable('news_lang', [
            'news_id' => $this->integer(),
            'lang_id' => $this->string(2),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            '_meta_data' => $this->text(),
            '_data' => $this->text(),
        ]);

        $this->addPrimaryKey('news_lang', ['news_id', 'lang_id']);
        $this->addForeignKey('news_lang', 'news_id', 'news', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news_lang');
        $this->dropTable('news');
    }
}
