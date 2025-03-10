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
            $table->float('highest_price')
                ->nullable()
                ->comment('該年最高價格');
            $table->float('lowest_price')
                ->nullable()
                ->comment('該年最高價格');
            $table->float('eps');
            $table->float('div');
            $table->float('roe')->comment('公司賺錢的效率');
            $table->float('net_income')->comment('淨利潤');
            $table->float('non_current_assets')->comment('長期投資（非流動資產）');
            $table->float('fixed_assets')->comment('固定資產');
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
