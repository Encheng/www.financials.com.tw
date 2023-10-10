<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\SchemaTrait;

class CreateCompanyFinancialStatementsTable extends Migration
{
    use SchemaTrait;
    protected $table_name = 'company_financial_statements';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schemaCreate(function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('year');
            $table->float('eps');
            $table->float('div');
            $table->float('roe');
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
