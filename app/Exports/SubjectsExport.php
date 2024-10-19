<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubjectsExport implements FromCollection, WithHeadings
{
    // Return an empty collection, no data
    public function collection()
    {
        return collect([]);
    }

    // Define the headers
    public function headings(): array
    {
        return [
           'start_time', 'end_time', 'name', 'code', 'description', 'qr', 'section', 'day', 'image', 'instructor', 'instructor_number', 'email'
        ];
    }
}

