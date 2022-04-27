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
            $parsed = json_decode(str_replace("'", '"', $record['emails']), true);
            if ($parsed) {
                $parsedCollec = collect($parsed);
                $normalizedEmail = $parsedCollec->where('type', '=', 'current_professional')->first();
                if (!$normalizedEmail)  {
                    $normalizedEmail = $parsedCollec[0]['address'];
                }
                else {
                    $normalizedEmail = $normalizedEmail['address'];
                }
            }
            DB::table('contacts')->insert([
                'full_name' => $record['full_name'],
                'first_name' => ucfirst($record['first_name']), // capitalize
                'middle_initial' => $record['middle_initial'],
                'middle_name' => $record['middle_name'],
                'last_name' => $record['last_name'],
                'linkedin_url' => $record['linkedin_url'],
                'email' => $normalizedEmail,

                'industry' => $record['industry'],
                'job_title' => $record['job_title'],
                'job_company_size' => $record['job_company_size'],
                'job_company_location_country' => $record['job_company_location_country'],
            ]);
        };
        DB::commit();
    }
}
