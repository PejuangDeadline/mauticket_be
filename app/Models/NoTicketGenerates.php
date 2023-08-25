<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoTicketGenerates extends Model
{
    protected $table = 'no_ticket_generates';
    protected $fillable = [
        'no_urut',
        'no_ticket',
        'created_by'
    ];
}
