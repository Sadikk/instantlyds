<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function getDropdown(Request $request) {
        $request->validate([
            //TODO whitelist field
            'field' => 'required|string'
        ]);
        $result = DB::table('contacts')
            ->select($request->input('field'))
            ->groupBy($request->input('field'))
            ->orderBy($request->input('field'))
            ->get()
            ->pluck($request->input('field'))
            ->all();
        return $this->makeResponse($request, ['options' => array_values(array_filter($result)) ]);
    }

    public function export(Request $request) {
        $request->validate([
            'only_with_email' => 'in:true,false'
        ]);
        // set header
        $columns = [
            'full_name',
            'first_name',
            'middle_initial',
            'middle_name',
            'last_name',
            'linkedin_url',
            'email',

            'industry',
            'job_title',
            'job_company_size',
            'job_company_location_country'
        ];

        // create csv
        return response()->streamDownload(function() use($columns, $request) {
            $file = fopen('php://output', 'w+');
            fputcsv($file, $columns);

            $data = Contact::select($columns);
            if ($request->get('only_with_email', 'false') === 'true') {
                $data = $data->whereNotNull('email');
            }

            $data = $data->cursor()
                ->each(function ($data) use ($file) {
                    $data = $data->toArray();
                    fputcsv($file, $data);
                });

            fclose($file);
        }, 'export-'.date('d-m-Y').'.csv');
    }
}
