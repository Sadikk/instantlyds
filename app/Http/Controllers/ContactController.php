<?php

namespace App\Http\Controllers;

use App\Domain\Actions\BuildFilterQueryAction;
use App\Helpers\LogHelpers;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function getDropdown(Request $request) {
        $request->validate([
            //TODO whitelist field
            'field' => 'required|string'
        ]);
        if ($request->input('field') === 'job_title') {
            return $this->makeResponse($request, ['options' => [
                'Ceo',
                'Partner',
                'Owner',
                'Founder',
                'Manager',
                'Co-founder',
                'CTO',
                'CFO',
                'Chief financial officer',
                'CXO',
                'VP',
                'Vice President',
                'Account Manager',
                'Senior Account Manager',
                'Sales',
                'Sales Manager',
                'Sales Director',
                'Business Development',
                'Business Manager',
                'Chief Executive Officer',
                'Chief Sales Officer',
                'Marketing Manager',
                'Marketing Director',
                'President'
            ]]);
        }
        $field = $request->input('field');
        $result = Cache::remember($request->input('field'), new \DateInterval('P2D'), function() use($field) {
            return array_values(array_filter(
                DB::table('contacts')
                    ->select($field)
                    ->groupBy($field)
                    ->orderBy($field)
                    ->get()
                    ->pluck($field)
                    ->all()
            ));
        });
        return $this->makeResponse($request, ['options' => $result ]);
    }

    public function export(Request $request) {
        $request->validate([
            'only_with_email' => 'in:true,false',
            'job_title' => 'nullable',
            'job_company_size' => 'nullable',
            'job_company_location_country' => 'nullable',
            'industry' => 'nullable'
        ]);
        // set header
        $columns = [
            'first_name',
            'last_name',
            'gender',
            'linkedin_url',
            'facebook_url',
            'twitter_url',
            'work_email',
            'mobile_phone',
            'industry',
            'job_title',
            'job_title_levels',
            'job_company_name',
            'job_company_website',
            'job_company_size',
            'job_company_industry',
            'job_company_linkedin_url',
            'job_company_facebook_url',
            'job_company_twitter_url',
            'job_company_location_locality',
            'job_company_location_metro',
            'job_company_location_region',
            'job_company_location_street_address',
            'job_company_location_country',
            'job_company_location_continent',
            'job_summary',
            'linkedin_connections',
            'inferred_salary',
            'inferred_years_experience',
            'summary',
            'phone_numbers',
            'email',
            'email_type',
        ];
        // create csv
        return response()->streamDownload(function() use($columns, $request) {
            $file = fopen('php://output', 'w+');
            fputcsv($file, $columns);

            $data = Contact::select($columns);
            $data = (new BuildFilterQueryAction)($data, collect($request->all()));
            Log::info(LogHelpers::getEloquentSqlWithBindings($data));
            $data = $data->cursor()
                ->each(function ($data) use ($file) {
                    $data = $data->toArray();
                    fputcsv($file, $data);
                });

            fclose($file);
        }, 'export-'.date('d-m-Y').'.csv');
    }
}
