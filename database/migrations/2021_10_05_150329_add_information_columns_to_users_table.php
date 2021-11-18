<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddInformationColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('title')->nullable()->after('id');
            $table->string('last_name')->after('name');
            $table->integer('sex');
            $table->bigInteger('identification');
            $table->bigInteger('sub_department_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['title', 'last_name', 'sex', 'identification', 'department_id', 'sub_department_id']);
        });
    }
}
