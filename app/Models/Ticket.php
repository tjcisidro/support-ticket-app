<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'full_name',
        'email',
        'phone',
        'priority',
        'type',
        'contact_method',
        'attachments',
        'status',
        'notes',
    ];
    protected $casts = [
        'attachments' => 'array',
    ];
}