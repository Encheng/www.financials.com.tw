<?php

namespace App\Services\Migration;

use App;
use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait SchemaTrait
{
    protected function getTableName()
    {
        return $this->table_name;
    }

    protected function schemaCreate(Closure $closure)
    {
        if (
            !Schema::connection($this->getConnection())
                   ->hasTable($this->getTableName())
        ) {
            Schema::connection($this->getConnection())
                  ->create($this->getTableName(), $closure);
        }
    }

    protected function schemaDrop(Closure $closure = null)
    {
        $table_name = $this->getTableName();
        if (App::environment('local', 'testing')) {
            Schema::connection($this->getConnection())
                  ->dropIfExists($table_name);
        } else {
            $rename_table = "down_{$table_name}_" . date('YmdHis');
            Schema::connection($this->getConnection())
                  ->rename($table_name, $rename_table);
            if ($closure) {
                Schema::connection($this->getConnection())
                      ->table($rename_table, function (Blueprint $table) use ($table_name, $closure) {
                          $closure($table, $table_name);
                      });
            }
        }
    }

    protected function schemaTable($closure)
    {
        Schema::connection($this->getConnection())
              ->table($this->getTableName(), $closure);
    }
}
