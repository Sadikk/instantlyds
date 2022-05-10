<?php

namespace App\Domain\Actions;

use App\Helpers\LogHelpers;
use App\Models\Contact;
use Illuminate\Support\Facades\Cache;

class CountQueryAction
{
    public function __invoke(array $parameters)
    {
        $query = Contact::query();
        $query = (new BuildFilterQueryAction)($query, collect($parameters));
        $hash = md5(LogHelpers::getEloquentSqlWithBindings($query));
        $count = Cache::remember($hash, new \DateInterval('P7D'), function() use($query) {
            return $query->count();
        });
        return $count;
    }

}
