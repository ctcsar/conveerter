<?php


namespace app\models;



use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_referral_link".
 *
 **/
class DataBase extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            ['id' , 'integer' ],
            ['CharCode' , 'string' ],
            ['Name' , 'string' ],
            ['Value' , 'double' ],
            ['currentDate' , 'string' ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'NumCode'=> 'Код валюты',
            'CharCode'=> 'Обозначение валюты',
            'Name'=> 'Русское название валюты',
            'Value' => 'Текущий курс',
        ];
    }

    public static function  createOrRefreshTable($date)
    {

        $xml = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $date);
        $xmlParsed = json_decode(json_encode(simplexml_load_string($xml)));

        foreach ($xmlParsed->Valute as $item){
            $result = self::findOne((int)$item->NumCode) ?? new self;
            $result->id = (int)$item->NumCode;
            $result->CharCode = $item->CharCode;
            $result->Name = $item->Name;
            $result->Value = (double)str_replace(',', '.', $item->Value);
            $result->currentDate = $date;
            $result->save();
        }


    }

}