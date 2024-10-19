<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
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
           'name', 'email', 'section', 'student_number'
        ];
    }
}
