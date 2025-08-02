<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

class Question extends Model
{
    protected $fillable = [
        'question',
        'image',
        'options',
        'answer',
        'difficulty',
        'question_type',
        'education_level',
        'topic_id',
        'institution',
        'source',
        'year',
        'region',
        'uf',
        'doc',
        'answer_doc',
    ];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

}

