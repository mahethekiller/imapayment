<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title','slug','description',
        'member_price','non_member_price','gst_percent',
        'workshop_mode','enable_pdf_download','pdf_path','active','banner_path','can_have_extra_members'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function discountRules()
    {
        return $this->hasMany(DiscountRule::class);
    }
}

