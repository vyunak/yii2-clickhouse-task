<?php

namespace app\models;

use bashkarev\clickhouse\ActiveRecord;
use Yii;
use yii\base\Model;
use yii\validators\Validator;

/**
 *
 * @property string $hash_key [String]
 * @property string $message [String]
 * @property string $created_at [Date]
 */
class NginxLog extends ActiveRecord
{
    public const TIME_PATTERN = '/\[(\d{2}\/\w+\/\d{4}:\d{2}:\d{2}:\d{2} \+\d{4})\]/';
    public const TIME_PATTERN_VALIDATE = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
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
            [['hash_key', 'message'], 'safe'],
            [['created_at'], 'match', 'pattern' => self::TIME_PATTERN_VALIDATE, 'not' => false],
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

        preg_match_all(self::TIME_PATTERN, $data['line'], $matches);

        if (isset($matches[1][0])) {
            $date = $matches[1][0];
        } else {
            return false;
        }

        $this->created_at = Yii::$app->formatter->asDatetime($date, 'yyyy-MM-dd HH:mm:ss');;

        return true;
    }

    public static function validateTime($input)
    {
        $error = null;

        $validator = Validator::createValidator('match', null, [], ['pattern' => NginxLog::TIME_PATTERN_VALIDATE]);
        $validator->validate($input, $error);

        return empty($error);
    }
}
