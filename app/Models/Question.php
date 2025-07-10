<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'institution',
        'source',
        'year',
        'region',
        'uf',
        'doc'
    ];
    

    /**
     * Check if the question has an image
     */
    public function hasImage()
    {
        return !empty($this->image) && Storage::disk('public')->exists($this->image);
    }
}

