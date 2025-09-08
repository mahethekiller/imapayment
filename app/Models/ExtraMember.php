<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraMember extends Model
{
    protected $fillable = ['registration_id','name','email','phone'];
    public function registration() { return $this->belongsTo(Registration::class); }
}

