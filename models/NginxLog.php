<?php

namespace app\models;

use bashkarev\clickhouse\ActiveRecord;
use Yii;
use yii\base\Model;

/**
 *
 * @property string $hash_key [String]
 * @property string $message [String]
 * @property string $created_at [Date]
 */
class NginxLog extends ActiveRecord
{
    public const PATH_TO_ACCESS_FILE = '/app/runtime/nginx/access.log';

    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'nginx_log';
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'match', 'pattern' => '^([1-9]\d{3}|0\d{3})-(0[1-9]|1[0-2])-([0-2][1-9]|3[0-1]) (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$'],
        ];
    }

    /**
     * @param $hash
     * @return bool
     */
    public static function hashExists($hash)
    {
        return self::find()->andWhere(['hash_key' => $hash])->exists();
    }

    /**
     * @param $data
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function fill($data)
    {
        $this->hash_key = $data['hash'];
        $this->message = $data['line'];

        $pattern = '/\[(\d{2}\/\w+\/\d{4}:\d{2}:\d{2}:\d{2} \+\d{4})\]/';
        preg_match($pattern, $data['line'], $matches);

        if (isset($matches[1])) {
            $date = $matches[1];
        } else {
            return false;
        }

        $this->created_at = Yii::$app->formatter->asDatetime($date, 'yyyy-MM-dd HH:mm:ss');;

        return true;
    }
}
