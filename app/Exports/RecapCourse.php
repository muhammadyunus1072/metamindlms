<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RecapCourse implements FromCollection, WithHeadings, WithMapping
{
    protected $request;
    protected $index = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;
        
        $data = DB::table('view_course_member');
        return $data->select(
            'view_course_member.*', 
            DB::raw('count(*) as total_member')
        )
        ->when($request->search, function ($query) use ($request) {
            $search_value = '%' . $request->search . '%';
            $query->where('course_title', 'like', $search_value)
            ->orWhere('course_code', 'like', $search_value);
        })
        ->groupBy('course_id')
        ->get();
    }

    public function headings(): array
    {
        return [
            "No",
            "Kode Kursus", 
            "Kursus", 
            "Total Member", 
        ];
    }

    public function map($data): array
    {
        return [
            ++$this->index,
            $data->course_code,
            $data->course_title,
            $data->total_member,
        ];
    }
}
