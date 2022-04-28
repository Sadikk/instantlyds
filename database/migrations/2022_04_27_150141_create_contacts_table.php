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

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('work_email')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('job_title_levels')->nullable();
            $table->string('job_company_name')->nullable();
            $table->string('job_company_website')->nullable();
            $table->string('job_company_industry')->nullable();
            $table->string('job_company_linkedin_url')->nullable();
            $table->string('job_company_facebook_url')->nullable();
            $table->string('job_company_twitter_url')->nullable();
            $table->string('job_company_location_locality')->nullable();
            $table->string('job_company_location_metro')->nullable();
            $table->string('job_company_location_region')->nullable();
            $table->string('job_company_location_street_address')->nullable();
            $table->string('job_company_location_continent')->nullable();
            $table->string('job_summary')->nullable();
            $table->integer('linkedin_connections')->nullable();
            $table->string('inferred_salary')->nullable();
            $table->smallInteger('inferred_years_experience')->nullable();
            $table->string('summary')->nullable();
            $table->string('phone_numbers')->nullable();
            $table->string('email')->nullable();
            $table->string('email_type')->nullable();

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
