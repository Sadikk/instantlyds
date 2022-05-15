<?php

namespace App\Domain\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Apply filters to query builder
 */
class BuildFilterQueryAction
{
    public function __invoke(Builder $query, Collection $params) : Builder
    {
        if ($params->get('only_with_email', 'false') === 'true') {
            $query = $query->whereNotNull('email');
        }
        $query = $this->applyInFilter($query, 'job_title', $params->get('job_title', null));
        $query = $this->applyInFilter($query, 'job_company_size', $params->get('job_company_size', null));
        $query = $this->applyInFilter($query, 'job_company_location_country', $params->get('job_company_location_country', null));
        $query = $this->applyInFilter($query, 'job_title_levels', $params->get('job_title_levels', null));
        $query = $this->applyInFilter($query, 'job_company_industry', $params->get('industry', null));
        return $query;
    }

    private function applyInFilter(Builder $query, string $field, $data) {
        if (is_null($data) || $data === 'null') {
            return $query;
        }
        if (!is_array($data)) {
            $data = [$data];
        }
        if ($field === 'job_title') {
            $query = $query->where(function($q) use ($field, $data){
                foreach ($data as $title) {
                    $q->orWhere($field, 'LIKE', '%'.strtolower($title).'%');
                }
            });
            return $query;
        }
        else if ($field === 'job_title_levels') {
            $query = $query->where(function($q) use ($field, $data){
                foreach ($data as $title) {
                    $q->orWhere($field, 'LIKE', "%'".strtolower($title)."'%");
                }
            });
            return $query;
        }
        else {
            return $query->whereIn($field, array_map('strtolower', $data));
        }
    }
}
