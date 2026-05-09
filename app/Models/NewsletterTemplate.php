<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterTemplate extends Model
{
    protected $fillable = ['subject', 'content', 'image'];
}
