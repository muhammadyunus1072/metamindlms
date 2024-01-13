<?php

namespace Database\Seeders;

use App\Models\CategoryCourse;
use App\Models\OfflineCourse;
use App\Models\OfflineCourseRegistrar;
use App\Models\OfflineCourseAttendance;
use App\Models\OfflineCourseCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfflineCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            $offlineCourse = OfflineCourse::create([
                "image" => 'default.png',
                "title" => "Pengembangan Pola Pikir Sebagai Kunci menjadi Percaya Diri $i",
                "description" => "Apakah Anda selalu bermain aman? Khawatir gagal? Ngeri ketika menerima umpan balik yang membangun? Apakah Anda lebih suka membawa hidup dan karier Anda ke tingkat berikutnya, memperluas kemungkinan Anda, meningkatkan kenyamanan Anda dalam mengambil risiko, dan meningkatkan kinerja Anda di tempat kerja? Cari tahu bagaimana mengubah pola pikir Anda menjadi pertumbuhan dapat menuai hasil besar, baik dalam pekerjaan maupun kehidupan. Pola pikir berkembang adalah keyakinan bahwa Anda dapat terus belajar, tumbuh, dan berkembang. Dengan merasa nyaman mengambil risiko, menerima umpan balik, belajar dari pengalaman, dan membingkai ulang 'kegagalan', Anda sedang menuju pola pikir berkembang dan kehidupan yang lebih bahagia dan lebih memuaskan.",
                "quota" => 100,
                "price" => 100_000 * ($i +1),
                "price_before_discount" => 200_000 * ($i +1),
                "date_time_start" => Carbon::now()->addDays(3)->format('Y-m-d 09:00:00'),
                "date_time_end" => Carbon::now()->addDays(3)->format('Y-m-d 12:00:00'),
            ]);

            $categoryCourse = CategoryCourse::first();
            OfflineCourseCategory::create([
                'offline_course_id' => $offlineCourse->id,
                'category_course_id' => $categoryCourse->id,
            ]);

            $categoryCourse = CategoryCourse::find(2);
            OfflineCourseCategory::create([
                'offline_course_id' => $offlineCourse->id,
                'category_course_id' => $categoryCourse->id,
            ]);

            $randUserId = rand(1, 10);
            $registrar = OfflineCourseRegistrar::create([
                'user_id' => $randUserId,
                'offline_course_id' => $offlineCourse->id,
                'created_at' => "2023-05-0" . rand(1, 9) . " 16:00:" . rand(10, 59),
            ]);
            OfflineCourseAttendance::create([
                'offline_course_registrar_id' => $registrar->id,
                'created_at' => "2023-05-0" . rand(1, 9) . " 16:00:" . rand(10, 59),
            ]);

            $randUserId = rand(1, 10);
            OfflineCourseRegistrar::create([
                'user_id' => $randUserId,
                'offline_course_id' => $offlineCourse->id,
                'created_at' => "2023-05-0" . rand(1, 9) . " 16:00:" . rand(10, 59),
            ]);
        }
    }
}
