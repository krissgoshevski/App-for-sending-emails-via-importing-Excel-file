<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentEmailModel extends Model
{
    use HasFactory;

    protected $table = 'sent_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'emails', 'korisnik', 'adresa_servis', 'pocetok', 'kraj', 'vremetraenje', 'verzija', 'naslov', 'prva_recenica', 'pricina'
    ];
}
