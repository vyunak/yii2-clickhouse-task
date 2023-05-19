<?php

use bashkarev\clickhouse\Migration;

class m230518_145736_nginx_log extends Migration
{

    public function up()
    {
        $this->createTable('nginx_log', [
            'hash_key' => $this->string(),
            'message' => $this->text(),
            'created_at' => $this->dateTime(),
        ], 'ENGINE=MergeTree() ORDER BY created_at');
    }

    public function down()
    {
        $this->dropTable('nginx_log');
    }

}