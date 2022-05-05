<?php

namespace App\Helpers;

class ExportHelpers
{
    public static function generateFilename(array $parameters) : string {
        $industry = join(' ', $parameters['industry'] ?? []);
        $job_title_levels = join(' ', $parameters['job_title_levels'] ?? []);
        $country = join(' ', $parameters['job_company_location_country'] ?? []);
        return $industry.' '.$job_title_levels.' '.$country.'.csv';
    }
}
