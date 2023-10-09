<?php

use App\Services\Migration\SchemaTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {

    use SchemaTrait;

    protected $connection = 'mysql';
    protected $table_name = 'cms_logs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schemaCreate(function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('level', [
                'EMERGENCY',
                'ALERT',
                'CRITICAL',
                'ERROR',
                'WARNING',
                'NOTICE',
                'INFO'
            ]);
            $table->integer('admin_id', false, true);
            $table->string('description')
                  ->nullable();
            $table->json('json_info')
                  ->nullable();
            $table->string('class_path')
                  ->nullable();
            $table->timestamps();

            $table->index('level');
            $table->index('class_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schemaDrop(function (Blueprint $table, $table_name) {
        });
    }
};
