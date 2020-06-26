<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSmsEnabledToCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_details', function (Blueprint $table) {
            $table->boolean('sms_enabled')->after('status')->nullable()->default(1);
            $table->string('sid')->after('sms_enabled')->nullable()->default(null);
            $table->string('token')->after('sid')->nullable()->default(null);
            $table->text('twilio_response')->after('sid')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_details', function (Blueprint $table) {
            $table->dropColumn('sms_enabled');
            $table->dropColumn('sid');
            $table->dropColumn('token');
            $table->dropColumn('twilio_response');
        });
    }
}
