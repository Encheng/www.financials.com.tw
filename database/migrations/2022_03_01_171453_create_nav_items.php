<?php

use App\Services\Migration\SchemaTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {

    use SchemaTrait;

    protected $connection = 'mysql';
    protected $table_name = 'nav_items';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schemaCreate(function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('parent_id', false, true)
                  ->nullable()
                  ->index();
            $table->integer('active_nav_item_id', false, true)
                  ->nullable();
            $table->string('name', 50);
            $table->string('route_name', 255)
                  ->nullable()
                  ->unique();
            $table->string('role')
                  ->nullable()
                  ->comment('管理權限');
            $table->string('icon', 50)
                  ->nullable()
                  ->comment('icon class');
            $table->boolean('display')
                  ->default(true)
                  ->comment('是否在選單隱藏，0隱藏、1不隱藏');
            $table->timestamps();
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
