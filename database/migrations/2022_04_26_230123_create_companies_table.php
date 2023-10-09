<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\SchemaTrait;

class CreateCompaniesTable extends Migration
{
    use SchemaTrait;
    protected $table_name = 'companies';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schemaCreate(function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('stock_symbol');
            $table->string('industry');
            $table->longText('introduction');
            $table->string('stock_exchanges');
            $table->string('stock_price');
            $table->string('nav');
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
        $this->schemaDrop();
    }
}
