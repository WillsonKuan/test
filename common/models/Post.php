<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * @property Comment[] $comments
 * @property Adminuser $author
 * @property Poststatus $status0
 */
class Post extends \yii\db\ActiveRecord
{
    private $_oldTag;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status', 'author_id'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Poststatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'title' => '标题',
            'content' => '评论',
            'tags' => '标签',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'author_id' => '作者',
            'authorName'=>'作者',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Poststatus::className(), ['id' => 'status']);
    }

    //重载beforesave方法，令update_time和insert_time自动写入
    public function beforeSave($insert)
    {
        if  ($insert === true)
        {
            //第一次新建情况
            $this->update_time = time();
            $this->create_time = time();
        }
        else
        {
            //更新情况
            $this->update_time = time();
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    //重载afterFind方法，取得未更新前的tag
    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->_oldTag = $this->tags;
    }


    //重载afterSave方法，自动更新tag数量到Tag表中
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        //增加
        Tag::updateTag($this->_oldTag,$this->tags);
    }

    //重载afterDelte方法，自动更新tag数量到Tag表中
    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub
        //删除后字符串是空了
        Tag::updateTag($this->_oldTag,' ');
    }
}
