<?php

namespace app\commands;

use app\models\NginxLog;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;
use yii\validators\Validator;
use yii\widgets\ActiveForm;

/**
 * For fill and view information NGINX access log
 */
class NginxController extends Controller
{

    /**
     * Watches the file in while and constantly updates the information.
     * @return int Exit code
     */
    public function actionWatchStuckData()
    {
        while (true) {

            if ($this->actionStuckData() == ExitCode::NOINPUT) {
                return ExitCode::NOINPUT;
            }

            sleep(5);
        }
    }

    /**
     * Watches the file and constantly updates the information.
     * @return int Exit code
     * @throws InvalidConfigException
     */
    public function actionStuckData()
    {
        $handle = fopen(NginxLog::PATH_TO_ACCESS_FILE, 'r');

        if ($handle) {

            // Чтение файла построчно
            while (($line = fgets($handle)) !== false) {
                if (!empty($line)) {
                    $hash = hash('md5', $line);

                    if (!NginxLog::hashExists($hash)) {
                        $newLog = new NginxLog();
                        $data = compact('line', 'hash');

                        if ($newLog->fill($data)) {
                            $newLog->save();
                        }
                    }
                }
            }

            // Закрываем файл
            fclose($handle);
        } else {
            echo "Не удалось открыть файл.";
            return ExitCode::NOINPUT;
        }
        return ExitCode::OK;
    }

    /**
     * Displays information within a time interval.
     * @param $startDate
     * @param $finishDate
     * @return int
     */
    public function actionGetData($startDate, $finishDate)
    {
        if (!NginxLog::validateTime($startDate) || !NginxLog::validateTime($finishDate)) {
            echo 'Ошибка во вводимых данных.' . PHP_EOL;
            return ExitCode::OK;
        }

        $request = NginxLog::find()
            ->andWhere(['>=', 'created_at', $startDate])
            ->andWhere(['<=', 'created_at', $finishDate]);


        // Можно использовать batch при большом количестве данных, each при маленьких
        foreach ($request->each() as $eachData) {
            /** @var $eachData NginxLog */
            echo $eachData->message;
        }
        return ExitCode::OK;
    }

    /**
     * Displays the number of records within a time interval.
     * @param $startDate
     * @param $finishDate
     * @return int
     */
    public function actionGetCount($startDate, $finishDate)
    {
        if (!NginxLog::validateTime($startDate) || !NginxLog::validateTime($finishDate)) {
            echo 'Ошибка во вводимых данных.' . PHP_EOL;
            return ExitCode::OK;
        }

        $result = NginxLog::find()
            ->andWhere(['>=', 'created_at', $startDate])
            ->andWhere(['<=', 'created_at', $finishDate])
            ->count();

        echo "Количество между \"$startDate\" и \"$finishDate\" = $result" . PHP_EOL;
        return ExitCode::OK;
    }

}