<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'quiz_id',
        'question',
        'answer',
    ];

    // when quiz is updated, update the search index
    protected $touches = ['quiz'];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array = $this->transform($array);

        $array['course_name'] = $this->quiz?->course?->name;
        $array['quiz_name'] = $this->quiz?->name;

        return $array;
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
