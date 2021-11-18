<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('detail')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();
        });

        if (config('database.default') != 'sqlite') {
            DB::statement('ALTER TABLE `equipments` AUTO_INCREMENT = 100000');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
}
