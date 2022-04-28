<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->index(['industry']);
            $table->index(['job_title']);
            $table->index(['job_company_size']);
            $table->index(['job_company_location_country']);
            $table->index(['email_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['industry']);
            $table->dropIndex(['job_title']);
            $table->dropIndex(['job_company_size']);
            $table->dropIndex(['job_company_location_country']);
            $table->dropIndex(['email_type']);
        });
    }
}
