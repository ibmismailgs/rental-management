<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('owner_info_id')->index()->nullable();
            $table->unsignedInteger('flat_info_id')->index()->nullable();
            $table->unsignedInteger('tenant_info_id')->index()->nullable();
            $table->unsignedInteger('rent_info_id')->index()->nullable();
            $table->unsignedInteger('account_id')->index()->nullable();
            $table->unsignedInteger('mobile_banking_id')->index()->nullable();
            $table->json('expense_category_id')->nullable();
            $table->string('rental_month')->index()->nullable();
            $table->tinyInteger('transaction_purpose')->nullable()->comment('1 = Rent Collect | 2 = Due Collect | 3 = Expense');
            $table->tinyInteger('payment_method')->nullable()->comment('1 = Cash, 2 = Bank Account | 3 = Mobile Banking');
            $table->json('amount');
            $table->date('date')->nullable();
            $table->string('mobile_transaction_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
