<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_claims', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_id');
            $table->bigInteger('user_id');
            $table->bigInteger('admin_id')->nullable();
            $table->string('problem')->nullable();
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
        Schema::dropIfExists('pre_claims');
    }
}
