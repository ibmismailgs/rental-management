<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlatInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flat_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('owner_info_id')->index();
            $table->string('flat_name');
            $table->double('flat_size');
            $table->tinyInteger('bedroom');
            $table->tinyInteger('daining_space')->nullable();
            $table->tinyInteger('bathroom');
            $table->tinyInteger('master_bedroom');
            $table->tinyInteger('guest_bedroom');
            $table->tinyInteger('balcony');
            $table->text('flat_photo')->nullable();
            $table->tinyInteger('rent_status')->default(0)->comment('1 = Rented | 0 = Not Rented');
            $table->tinyInteger('status')->default(1)->comment('1 = On | 0 = Off');
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
        Schema::dropIfExists('flat_infos');
    }
}
