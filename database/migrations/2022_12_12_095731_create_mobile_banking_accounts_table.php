<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileBankingAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_banking_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('mobile_banking_id')->index();
            $table->unsignedInteger('owner_info_id')->index();
            $table->string('mobile_no');
            $table->tinyInteger('status')->default(1)->comment('1 = Active | 0 = Inactive');
            $table->tinyInteger('created_by')->nullable();
            $table->tinyInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_banking_accounts');
    }
}
