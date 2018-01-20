<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    //字符串以正则表达式方法分拆成列表
    public static function string2array($tag)
    {
        if(!empty($tag)){
            //如果$tag字符串不为空，以preg_split分拆
            return preg_split("/[\s,]+/",trim($tag),-1,PREG_SPLIT_NO_EMPTY);
        }else{
            //如果$tag字符串为空，返回空列表
            return [];
        }
    }

    //增加Tag方法
    public static function addTag($tag)
    {
        //如果列表为空，返回
        if(empty($tag)) return;
        //遍历$tag
        foreach ($tag as $name) {
            //新建$tagList数组，用$tag中的值返回到数组中
            $tagList = Tag::find()->select('frequency,id')->where('name = :name', ['name' =>$name])->indexBy('id')->column();
            //获取$tag中值有多少行
            $count = Tag::find()->where('name = :name', ['name' =>$name])->count();
            //如果有1行或以上
            if($count>=1){
                //遍历$tagList数组
                foreach ($tagList as $item=>$value){
                    //新建$tagObj对象，该对象就是对应tag值的行
                    $tagObj = Tag::findOne($item);
                    //数量增加1
                    $tagObj->frequency+=1;
                    //update形式保存
                    $tagObj->save();
                }
            }else{
                //新建$tagObj对象，该对象为新行
                $tagObj = new Tag();
                //设置数量为1
                $tagObj->frequency = 1;
                //设置名字为tag值
                $tagObj->name = $name;
                //insert形式保存
                $tagObj->save();
            }
        }
    }

    public static function deleteTag($tag)
    {
        //如果列表为空，返回
        if(empty($tag)) return;
        //遍历$tag
        foreach ($tag as $name){
            //新建$tagList数组，用$tag中的值返回到数组中
            $tagList = Tag::find()->select('frequency,id')->where('name = :name', ['name'=>$name])->indexBy('id')->column();
            //获取$tag中值有多少行
            $count = Tag::find()->where('name = :name', ['name'=>$name])->count();
            //遍历$tagList数组
            foreach ($tagList as $item=>$value){
                //如果有1行或以上而且数量大于1
                if($count>=1 && $value>1){
                    //新建$tagObj对象，该对象就是对应tag值的行
                    $tagObj = Tag::findOne($item);
                    //数量减少1
                    $tagObj->frequency-=1;
                    //update形式保存
                    $tagObj->save();
                }else{
                    //新建$tagObj对象，该对象就是对应tag值的行
                    $tagObj = Tag::findOne($item);
                    //删除tag值的行
                    $tagObj->delete();
                }
            }
        }
    }

    public static function updateTag($oldTag,$newTag)
    {
        //如果新或旧tag字符串不为空
        if (!empty($oldTag) || !empty($newTag)){
            //以上面方法转换字符串为数组
            $oldTagArray = self::string2array($oldTag);
            $newTagArray = self::string2array($newTag);
            //增加tag,array_value为直接取字符串的值成为新数组，增加是新的在前面
            self::addTag(array_values(array_diff($newTagArray,$oldTagArray)));
            //删除tag,array_value为直接取字符串的值成为新数组，删除是旧的在前面
            self::deleteTag(array_values(array_diff($oldTagArray,$newTagArray)));
        }
    }
}
