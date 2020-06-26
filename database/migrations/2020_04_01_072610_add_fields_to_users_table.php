<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('specialism',255)->after('stripe_response')->nullable()->default(null);
            $table->string('qualifications',255)->after('specialism')->nullable()->default(null);
            $table->string('med_co_no',255)->after('qualifications')->nullable()->default(null);
            $table->string('mdu_no',255)->after('med_co_no')->nullable()->default(null);
            $table->text('qualifications_details')->after('mdu_no')->nullable()->default(null);
            $table->text('gp_med_co_legal_experience')->after('qualifications_details')->nullable()->default(null);
            $table->text('med_co_legal_experience')->after('gp_med_co_legal_experience')->nullable()->default(null);
            $table->string('signature',255)->after('med_co_legal_experience')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('specialism', 'qualifications', 'med_co_no', 'mdu_no', 'qualifications_details', 'gp_med_co_legal_experience', 'med_co_legal_experience', 'signature');
        });
    }
}
