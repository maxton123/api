<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    use HasFactory;

    protected $fillable = ['mail'];

    public function headings()
    {
        return $this->belongsTo(Headings::class, 'heading_id');
    }
}
