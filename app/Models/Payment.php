<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $casts = ['payload' => 'array'];
    protected $fillable = ['registration_id','provider','provider_txn_id','amount','status','payload'];
    public function registration() { return $this->belongsTo(Registration::class); }
}

