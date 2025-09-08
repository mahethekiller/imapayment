<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $casts = ['meta' => 'array'];
    protected $fillable = [
        'landing_page_id','user_id','name','email','login_email','mobile',
        'company','country','city','address','company_gst','preferred_city',
        'extra_members_count','base_amount','gst_amount','discount_amount','final_amount','status','meta'
    ];

    public function landingPage() { return $this->belongsTo(LandingPage::class); }
    public function extraMembers() { return $this->hasMany(ExtraMember::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}

