<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'status',
        'detail',
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class);
    }

    public function start()
    {
        $this->update(['status' => 'ongoing']);
    }

    public function finish()
    {
        $this->update(['status' => 'finished']);
    }

    public function votes()
    {
        return $this->hasManyThrough(
            \App\Models\Vote::class,
            \App\Models\Voter::class,
            'agenda_id', 
            'voter_id',  
            'id',        
            'id'         
        );
    }
}