<?php

namespace app\console\controllers;

use yii\helpers\Console;

class MigrateController extends \bashkarev\clickhouse\console\controllers\MigrateController
{

    public function createMigrationHistoryTable()
    {
        $tableName = $this->db->schema->getRawTableName($this->migrationTable);
        $this->stdout("Creating migration history table \"$tableName\"...", Console::FG_YELLOW);
        $this->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'String',
            'date' => 'Date',
            'apply_time' => 'UInt32',
            'is_deleted' => 'UInt8' //0 active 1 //deleted
        ], 'ENGINE=ReplacingMergeTree() ORDER BY date')->execute();

        $this->addMigrationHistory(self::BASE_MIGRATION);
        $this->stdout("Done.\n", Console::FG_GREEN);
    }

}
