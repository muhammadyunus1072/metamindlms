<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CourseMember implements FromCollection, WithHeadings, WithMapping
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
        )
        ->when($request->search, function ($query) use ($request) {
            $search_value = '%' . $request->search . '%';
            $query->where('course_title', 'like', $search_value)
            ->orWhere('member_name', 'like', $search_value)
            ->orWhere('course_review_rating', 'like', $search_value);
        })
        ->when($request->daterange, function ($query) use ($request) {
            $date = explode(" - ", $request->daterange);
            $start_date = sql_datef($date[0]) . " 00:00:00";
            $end_date = sql_datef($date[1]) . " 23:59:59";
            $query->whereBetween('created_at', [$start_date, $end_date]);
        })
        ->when($request->member_id, function ($query) use ($request) {
            $member_id = dec($request->member_id);
            $query->where('member_id', $member_id);
        })
        ->when($request->course_id, function ($query) use ($request) {
            $course_id = dec($request->course_id);
            $query->where('course_id', $course_id);
        })
        ->when($request->rating, function ($query) use ($request) {
            $query->where('course_review_rating', $request->rating);
        })
        ->when($request->progress, function ($query) use ($request) {
            $progress = explode(" - ", $request->progress);
            $min_progress = $progress[0];
            $max_progress = $progress[1];
            $query->whereBetween('progress', [$min_progress, $max_progress]);
        })
        ->get();
    }

    public function headings(): array
    {
        return [
            "No",
            "Kode Kursus", 
            "Kursus", 
            "Member", 
            "Rating", 
            "Review", 
            "Progress", 
            "Tanggal Bergabung"
        ];
    }

    public function map($data): array
    {
        return [
            ++$this->index,
            $data->course_code,
            $data->course_title,
            $data->member_name,
            $data->course_review_rating,
            $data->course_review_comment,
            $data->progress,
            $data->created_at,
        ];
    }
}
