<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('owner_info_id')->index();
            $table->string('tenant_name');
            $table->string('email');
            $table->string('contact_no');
            $table->string('family_member')->nullable();
            $table->tinyInteger('gender');
            $table->text('address')->nullable();
            $table->text('tenant_photo')->nullable();
            $table->json('card_name')->nullable();
            $table->json('card_no')->nullable();
            $table->json('card_photo')->nullable();
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
        Schema::dropIfExists('tenant_infos');
    }
}
