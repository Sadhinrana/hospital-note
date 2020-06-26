<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleIdToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->tinyInteger('role_id')->after('description')->default(0);
            $table->tinyInteger('role_type')->after('role_id')->default(1);
            $table->tinyInteger('sort_id')->after('role_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn('role_type');
            $table->dropColumn('sort_id');
        });
    }
}
