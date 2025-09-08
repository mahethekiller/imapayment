<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    protected $fillable = ['landing_page_id', 'type', 'threshold', 'value', 'active'];

    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class);
    }
}
