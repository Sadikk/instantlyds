<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('full_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_initial')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('email')->nullable();
            //TODO add more columns

            $table->string('industry')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_company_size')->nullable();
            $table->string('job_company_location_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
