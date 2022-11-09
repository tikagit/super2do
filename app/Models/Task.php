<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use App\Traits\RecordSignature;

class Task extends Model
{
    // use RecordSignature;

    public $guarded = ["id", "created_at", "updated_at"];
    public $timestamps = true;
    public $incrementing = true;
    protected $table = "task";
    protected $primaryKey = "id";

    public static function findRequested()
    {
        $query = Task::query();

        // search results based on user input
        \Request::input('id') and $query->where('id', \Request::input('id'));
        \Request::input('task') and $query->where('task', 'like', '%' . \Request::input('task') . '%');
        \Request::input('status') and $query->where('status', 'like', '%' . \Request::input('status') . '%');
        \Request::input('created_at') and $query->where('created_at', \Request::input('created_at'));
        \Request::input('updated_at') and $query->where('updated_at', \Request::input('updated_at'));

        // sort results
        \Request::input("sort") and $query->orderBy(\Request::input("sort"), \Request::input("sortType", "asc"));

        // paginate results
        return $query->paginate(15);
    }

    public static function validationRules($attributes = null)
    {
        $rules = [
            'task' => 'required|string|max:100',
        ];

        // no list is provided
        if (!$attributes)
            return $rules;

        // a single attribute is provided
        if (!is_array($attributes))
            return [$attributes => $rules[$attributes]];

        // a list of attributes is provided
        $newRules = [];
        foreach ($attributes as $attr)
            $newRules[$attr] = $rules[$attr];
        return $newRules;
    }

    public function pk()
    {
        return $this->{$this->primaryKey};
    }

}
