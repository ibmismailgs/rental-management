<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('owner_info_id')->index();
            $table->unsignedInteger('flat_info_id')->index();
            $table->unsignedInteger('tenant_info_id')->index();
            $table->string('rent_title');
            $table->double('flat_rent');
            $table->double('gas_bill');
            $table->double('water_bill');
            $table->double('service_charge');
            $table->double('total_rent');
            $table->text('tenant_photo')->nullable();
            $table->string('district');
            $table->string('thana');
            $table->string('holding');
            $table->string('road')->nullable();
            $table->string('post_code');
            $table->string('father_name');
            $table->date('birthdate');
            $table->tinyInteger('merital_status')->default(2)->comment('1 = Married | 2 = Unmarried');
            $table->tinyInteger('religion')->comment('1 = Islam | 2 = Hindu | 3 = Buddhist | 4 = Christian | 5 = Others' );
            $table->string('profession');
            $table->text('professional_address');
            $table->string('qualification');
            $table->string('tenant_nid');
            $table->string('tenant_mobile');
            $table->string('passport')->nullable();
            $table->string('emergency_name');
            $table->string('relation');
            $table->string('emergency_mobile');
            $table->text('emergency_address');
            $table->json('member_name')->nullable();
            $table->json('member_age')->nullable();
            $table->json('member_profession')->nullable();
            $table->json('member_mobile')->nullable();
            $table->string('made_name')->nullable();
            $table->string('made_nid')->nullable();
            $table->string('made_mobile')->nullable();
            $table->text('made_address')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_nid')->nullable();
            $table->string('driver_mobile')->nullable();
            $table->text('driver_address')->nullable();
            $table->string('previous_owner_name')->nullable();
            $table->string('previous_owner_nid')->nullable();
            $table->string('previous_owner_mobile')->nullable();
            $table->text('previous_owner_address')->nullable();
            $table->text('leave_reason')->nullable();
            $table->string('present_owner_nid');
            $table->date('issue_date');
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
        Schema::dropIfExists('rent_infos');
    }
}
