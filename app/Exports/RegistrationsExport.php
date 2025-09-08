<?php

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistrationsExport implements FromQuery, WithHeadings
{
    public function __construct(private $landingPageId) {}
    public function query() {
        return Registration::where('landing_page_id',$this->landingPageId)->with('extraMembers');
    }
    public function headings(): array {
        return ['id','name','email','mobile','company','final_amount','status','created_at'];
    }
}

