<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier',
        'voting_code',
        'is_used',
        'agenda_id',
    ];

    protected $casts = [
        'is_used' => 'boolean'
    ];

    public function vote()
    {
        return $this->hasOne(Vote::class);
    }

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'agenda_voter');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}