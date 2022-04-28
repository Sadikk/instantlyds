<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instantlyds:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        $csv = Reader::createFromPath($this->argument('file'), 'r');
        $csv->setHeaderOffset(0); //we don't want to insert the header
        foreach ($csv as $record) {
            $normalizedEmail = null;
            $normalizedEmailType = null;
            $parsed = json_decode(str_replace("'", '"', $record['emails']), true);
            if ($parsed) {
                $parsedCollec = collect($parsed);
                $normalizedEmail = $parsedCollec->where('type', '=', 'current_professional')->first();
                if (!$normalizedEmail)  {
                    $normalizedEmail = $parsedCollec[0]['address'];
                    $normalizedEmailType = $parsedCollec[0]['type'];
                }
                else {
                    $normalizedEmail = $normalizedEmail['address'];
                    $normalizedEmailType = $normalizedEmail['type'];
                }
            }
            DB::table('contacts')->insert([
                'first_name' => ucfirst($record['first_name']), // capitalize
                'last_name' => ucfirst($record['last_name']), // capitalize
                'gender' => $record['gender'],
                'linkedin_url' => $record['linkedin_url'],
                'facebook_url' => $record['facebook_url'],
                'twitter_url' => $record['twitter_url'],
                'work_email' => $record['work_email'],
                'mobile_phone' => $record['mobile_phone'],
                'job_title_levels' => $record['job_title_levels'],
                'job_company_name' => $record['job_company_name'],
                'job_company_website' => $record['job_company_website'],
                'job_company_industry' => $record['job_company_industry'],
                'job_company_linkedin_url' => $record['job_company_linkedin_url'],
                'job_company_facebook_url' => $record['job_company_facebook_url'],
                'job_company_twitter_url' => $record['job_company_twitter_url'],
                'job_company_location_locality' => $record['job_company_location_locality'],
                'job_company_location_metro' => $record['job_company_location_metro'],
                'job_company_location_region' => $record['job_company_location_region'],
                'job_company_location_street_address' => $record['job_company_location_street_address'],
                'job_company_location_continent' => $record['job_company_location_continent'],
                'job_summary' => $record['job_summary'],
                'linkedin_connections' => $record['linkedin_connections'],
                'inferred_salary' => $record['inferred_salary'],
                'inferred_years_experience' => $record['inferred_years_experience'],
                'summary' => $record['summary'],
                'phone_numbers' => $record['phone_numbers'],

                'email' => $normalizedEmail,
                'email_type' => $normalizedEmail,

                'industry' => $record['industry'],
                'job_title' => $record['job_title'],
                'job_company_size' => $record['job_company_size'],
                'job_company_location_country' => $record['job_company_location_country'],
            ]);
        };
        DB::commit();
    }
}
