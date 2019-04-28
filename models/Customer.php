<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id_customer
 * @property string $name
 * @property string $surname
 * @property string $photo
 * @property int $id_created
 * @property int $id_updated
 * @property int $created
 * @property int $updated
 */
class Customer extends \yii\db\ActiveRecord
{
    
    public $file; // variable used to upload the picture
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'photo', 'id_created', 'id_updated', 'created', 'updated'], 'required'],
            [['id_created', 'id_updated', 'created', 'updated'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['surname'], 'string', 'max' => 100],
            [['photo'], 'string', 'max' => 250],
            // for security reasons file will only acept jpg files
            [['file'], 'file', 'extensions' => 'jpg', 'mimeTypes' => 'image/jpeg', 'maxFiles' => 1, 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_customer' => 'Id Customer',
            'name' => 'Name',
            'surname' => 'Surname',
            'photo' => 'Photo',
            'id_created' => 'Id Created',
            'id_updated' => 'Id Updated',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
