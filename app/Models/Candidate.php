<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_id',
        'name',
        'photo',
        'vision',
        'mission',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    // Add validation rules
    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string'
        ];
    }
}
