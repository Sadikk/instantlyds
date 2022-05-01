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
        try {
            DB::disableQueryLog();
            DB::beginTransaction();
            $csv = Reader::createFromPath($this->argument('file'), 'r');
            $csv->setHeaderOffset(0); //we don't want to insert the header
            foreach ($csv as $record) {
                $normalizedEmail = null;
                $normalizedEmailType = null;
                try {
                    $parsed = json_decode(str_replace("'", '"', $record['emails']), true);
                    if ($parsed) {
                        $parsedCollec = collect($parsed);
                        $normalizedEmail = $parsedCollec->where('type', '=', 'current_professional')->first();
                        if (!$normalizedEmail)  {
                            if (is_array($parsedCollec[0])) {
                                $normalizedEmail = $parsedCollec[0]['address'];
                                $normalizedEmailType = $parsedCollec[0]['type'];
                            }
                            else {
                                $normalizedEmail = $parsedCollec[0];
                                $normalizedEmailType = 'unknown';
                            }
                        }
                        else {
                            $normalizedEmailType = $normalizedEmail['type'];
                            $normalizedEmail = $normalizedEmail['address'];
                        }
                    }
                }
                catch (\Exception $ex) {
                    $this->info($this->argument('file').' --- Error with emails record: '.$record['emails']);
                }

                DB::table('contacts')->insert([
                    'first_name' => ucfirst($record['first_name']), // capitalize
                    'last_name' => ucfirst($record['last_name']), // capitalize
                    'gender' => $record['gender'],
                    'linkedin_url' => substr($record['linkedin_url'], 0, 250),
                    'facebook_url' => substr($record['facebook_url'],0 ,250),
                    'twitter_url' => substr($record['twitter_url'], 0,250),
                    'work_email' => $record['work_email'],
                    'mobile_phone' => $record['mobile_phone'],
                    'job_title_levels' => $record['job_title_levels'],
                    'job_company_name' => substr($record['job_company_name'], 0, 250),
                    'job_company_website' => $record['job_company_website'],
                    'job_company_industry' => $record['job_company_industry'],
                    'job_company_linkedin_url' =>  substr($record['job_company_linkedin_url'], 0,250),
                    'job_company_facebook_url' =>  substr($record['job_company_facebook_url'], 0, 250),
                    'job_company_twitter_url' =>  substr($record['job_company_twitter_url'], 0, 250),
                    'job_company_location_locality' => $record['job_company_location_locality'],
                    'job_company_location_metro' => $record['job_company_location_metro'],
                    'job_company_location_region' => $record['job_company_location_region'],
                    'job_company_location_street_address' => $record['job_company_location_street_address'],
                    'job_company_location_continent' => $record['job_company_location_continent'],
                    'job_summary' => $record['job_summary'],
                    'linkedin_connections' => intval($record['linkedin_connections']),
                    'inferred_salary' => substr($record['inferred_salary'], 0, 250),
                    'inferred_years_experience' => intval(substr($record['inferred_years_experience'],0, 250)),
                    'summary' => $record['summary'],
                    'phone_numbers' => substr($record['phone_numbers'],0, 250),

                    'email' => $normalizedEmail,
                    'email_type' => $normalizedEmailType,

                    'industry' =>  substr($record['industry'],0,250),
                    'job_title' => preg_replace("/[^A-Za-z0-9 ]/", '', substr($record['job_title'], 0, 250)),
                    'job_company_size' => $record['job_company_size'],
                    'job_company_location_country' => $record['job_company_location_country'],
                ]);
            };
            DB::commit();
        }
        catch (\Exception $ex) {
            $this->info($this->argument('file').' --- '.$ex->getMessage());
        }
    }
}
