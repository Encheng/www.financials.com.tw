<?php

use App\Services\Migration\SchemaTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    use SchemaTrait;

    protected $connection = 'mysql';
    protected $table_name = 'admins';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schemaCreate(function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', 50);
            $table->string('email')
                  ->unique();
            $table->string('password');
            $table->boolean('status')
                  ->default(false)
                  ->comment('帳號狀態');
            $table->boolean('protected')
                  ->default(false)
                  ->comment('資料保護');
            $table->string('role')
                  ->comment('管理權限');
            $table->string('comment')
                  ->nullable();
            $table->string('oauth_token')
                  ->nullable();
            $table->rememberToken();
            $table->timestamp('login_at')
                  ->nullable();
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
