<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseLearnDescription;
use App\Models\CourseSection;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //---------------------------
        //----------Course-----------
        //---------------------------
        Course::create([
            "level_id" => 1,
            "title" => "Pengembangan Pola Pikir Sebagai Kunci menjadi Percaya Diri",
            "description" => "Temukan bagaimana cara mengembangkan pola pikir serta kesempatan dalam karir dan kehidepan",
            "about" => "Apakah Anda selalu bermain aman? Khawatir gagal? Ngeri ketika menerima umpan balik yang membangun? Apakah Anda lebih suka membawa hidup dan karier Anda ke tingkat berikutnya, memperluas kemungkinan Anda, meningkatkan kenyamanan Anda dalam mengambil risiko, dan meningkatkan kinerja Anda di tempat kerja? Cari tahu bagaimana mengubah pola pikir Anda menjadi pertumbuhan dapat menuai hasil besar, baik dalam pekerjaan maupun kehidupan. Pola pikir berkembang adalah keyakinan bahwa Anda dapat terus belajar, tumbuh, dan berkembang. Dengan merasa nyaman mengambil risiko, menerima umpan balik, belajar dari pengalaman, dan membingkai ulang 'kegagalan', Anda sedang menuju pola pikir berkembang dan kehidupan yang lebih bahagia dan lebih memuaskan.",
            "price" => 279000,
            "price_before_discount" => 300_000,
            "url_image" => 'default.png',
        ]);

        Course::create([
            "level_id" => 1,
            "title" => "Pengembangan Pola Pikir Sebagai Kunci menjadi Percaya Diri",
            "description" => "Temukan bagaimana cara mengembangkan pola pikir serta kesempatan dalam karir dan kehidepan",
            "about" => "Apakah Anda selalu bermain aman? Khawatir gagal? Ngeri ketika menerima umpan balik yang membangun? Apakah Anda lebih suka membawa hidup dan karier Anda ke tingkat berikutnya, memperluas kemungkinan Anda, meningkatkan kenyamanan Anda dalam mengambil risiko, dan meningkatkan kinerja Anda di tempat kerja? Cari tahu bagaimana mengubah pola pikir Anda menjadi pertumbuhan dapat menuai hasil besar, baik dalam pekerjaan maupun kehidupan. Pola pikir berkembang adalah keyakinan bahwa Anda dapat terus belajar, tumbuh, dan berkembang. Dengan merasa nyaman mengambil risiko, menerima umpan balik, belajar dari pengalaman, dan membingkai ulang 'kegagalan', Anda sedang menuju pola pikir berkembang dan kehidupan yang lebih bahagia dan lebih memuaskan.",
            "price" => 279000,
            "price_before_discount" => 300_000,
            "url_image" => 'default.png',
        ]);

        Course::create([
            "level_id" => 1,
            "title" => "Pengembangan Pola Pikir Sebagai Kunci menjadi Percaya Diri",
            "description" => "Temukan bagaimana cara mengembangkan pola pikir serta kesempatan dalam karir dan kehidepan",
            "about" => "Apakah Anda selalu bermain aman? Khawatir gagal? Ngeri ketika menerima umpan balik yang membangun? Apakah Anda lebih suka membawa hidup dan karier Anda ke tingkat berikutnya, memperluas kemungkinan Anda, meningkatkan kenyamanan Anda dalam mengambil risiko, dan meningkatkan kinerja Anda di tempat kerja? Cari tahu bagaimana mengubah pola pikir Anda menjadi pertumbuhan dapat menuai hasil besar, baik dalam pekerjaan maupun kehidupan. Pola pikir berkembang adalah keyakinan bahwa Anda dapat terus belajar, tumbuh, dan berkembang. Dengan merasa nyaman mengambil risiko, menerima umpan balik, belajar dari pengalaman, dan membingkai ulang 'kegagalan', Anda sedang menuju pola pikir berkembang dan kehidupan yang lebih bahagia dan lebih memuaskan.",
            "price" => 279000,
            "price_before_discount" => 300_000,
            "url_image" => 'default.png',
        ]);

        Course::create([
            "level_id" => 1,
            "title" => "Pengembangan Pola Pikir Sebagai Kunci menjadi Percaya Diri",
            "description" => "Temukan bagaimana cara mengembangkan pola pikir serta kesempatan dalam karir dan kehidepan",
            "about" => "Apakah Anda selalu bermain aman? Khawatir gagal? Ngeri ketika menerima umpan balik yang membangun? Apakah Anda lebih suka membawa hidup dan karier Anda ke tingkat berikutnya, memperluas kemungkinan Anda, meningkatkan kenyamanan Anda dalam mengambil risiko, dan meningkatkan kinerja Anda di tempat kerja? Cari tahu bagaimana mengubah pola pikir Anda menjadi pertumbuhan dapat menuai hasil besar, baik dalam pekerjaan maupun kehidupan. Pola pikir berkembang adalah keyakinan bahwa Anda dapat terus belajar, tumbuh, dan berkembang. Dengan merasa nyaman mengambil risiko, menerima umpan balik, belajar dari pengalaman, dan membingkai ulang 'kegagalan', Anda sedang menuju pola pikir berkembang dan kehidupan yang lebih bahagia dan lebih memuaskan.",
            "price" => 279000,
            "price_before_discount" => 300_000,
            "url_image" => 'default.png',
        ]);

        Course::create([
            "level_id" => 1,
            "title" => "Pengembangan Pola Pikir Sebagai Kunci menjadi Percaya Diri",
            "description" => "Temukan bagaimana cara mengembangkan pola pikir serta kesempatan dalam karir dan kehidepan",
            "about" => "Apakah Anda selalu bermain aman? Khawatir gagal? Ngeri ketika menerima umpan balik yang membangun? Apakah Anda lebih suka membawa hidup dan karier Anda ke tingkat berikutnya, memperluas kemungkinan Anda, meningkatkan kenyamanan Anda dalam mengambil risiko, dan meningkatkan kinerja Anda di tempat kerja? Cari tahu bagaimana mengubah pola pikir Anda menjadi pertumbuhan dapat menuai hasil besar, baik dalam pekerjaan maupun kehidupan. Pola pikir berkembang adalah keyakinan bahwa Anda dapat terus belajar, tumbuh, dan berkembang. Dengan merasa nyaman mengambil risiko, menerima umpan balik, belajar dari pengalaman, dan membingkai ulang 'kegagalan', Anda sedang menuju pola pikir berkembang dan kehidupan yang lebih bahagia dan lebih memuaskan.",
            "price" => 279000,
            "price_before_discount" => 300_000,
            "url_image" => 'default.png',
        ]);

        //---------------------------
        //--Course Learn Description-
        //---------------------------
        CourseLearnDescription::create([
            "course_id" => 1,
            "description" => "Menemukan cara pola pikir yang berkembang dapat mempersiapkan kepercaryaan diri dan karir.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 1,
            "description" => "Identifikasi kapan saat kalian mulai memiliki pola pikir yang berkembang yang akan anda gunakan saat bekerja dan hidup.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 1,
            "description" => "Membawa pola pikir yang berkembang ke lingkungan organisasi anda.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 1,
            "description" => "Tersedia sertifikat.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 2,
            "description" => "Menemukan cara pola pikir yang berkembang dapat mempersiapkan kepercaryaan diri dan karir.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 2,
            "description" => "Identifikasi kapan saat kalian mulai memiliki pola pikir yang berkembang yang akan anda gunakan saat bekerja dan hidup.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 2,
            "description" => "Membawa pola pikir yang berkembang ke lingkungan organisasi anda.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 2,
            "description" => "Tersedia sertifikat.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 3,
            "description" => "Menemukan cara pola pikir yang berkembang dapat mempersiapkan kepercaryaan diri dan karir.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 3,
            "description" => "Identifikasi kapan saat kalian mulai memiliki pola pikir yang berkembang yang akan anda gunakan saat bekerja dan hidup.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 3,
            "description" => "Membawa pola pikir yang berkembang ke lingkungan organisasi anda.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 3,
            "description" => "Tersedia sertifikat.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 4,
            "description" => "Menemukan cara pola pikir yang berkembang dapat mempersiapkan kepercaryaan diri dan karir.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 4,
            "description" => "Identifikasi kapan saat kalian mulai memiliki pola pikir yang berkembang yang akan anda gunakan saat bekerja dan hidup.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 4,
            "description" => "Membawa pola pikir yang berkembang ke lingkungan organisasi anda.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 4,
            "description" => "Tersedia sertifikat.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 5,
            "description" => "Menemukan cara pola pikir yang berkembang dapat mempersiapkan kepercaryaan diri dan karir.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 5,
            "description" => "Identifikasi kapan saat kalian mulai memiliki pola pikir yang berkembang yang akan anda gunakan saat bekerja dan hidup.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 5,
            "description" => "Membawa pola pikir yang berkembang ke lingkungan organisasi anda.",
        ]);

        CourseLearnDescription::create([
            "course_id" => 5,
            "description" => "Tersedia sertifikat.",
        ]);

        //---------------------------
        //-----Course Section--------
        //---------------------------
        CourseSection::create([
            "course_id" => 1,
            "title" => "Pengenalan",
            "position" => 1,
        ]);

        CourseSection::create([
            "course_id" => 1,
            "title" => "Ringkasan Mengenai Pola Pikir yang Berkembang",
            "position" => 2,
        ]);

        CourseSection::create([
            "course_id" => 1,
            "title" => "6 Hambatan Pola Pikir yang Berkembang",
            "position" => 3,
        ]);

        CourseSection::create([
            "course_id" => 2,
            "title" => "Pengenalan",
            "position" => 1,
        ]);

        CourseSection::create([
            "course_id" => 2,
            "title" => "Ringkasan Mengenai Pola Pikir yang Berkembang",
            "position" => 2,
        ]);

        CourseSection::create([
            "course_id" => 2,
            "title" => "6 Hambatan Pola Pikir yang Berkembang",
            "position" => 3,
        ]);

        CourseSection::create([
            "course_id" => 3,
            "title" => "Pengenalan",
            "position" => 1,
        ]);

        CourseSection::create([
            "course_id" => 3,
            "title" => "Ringkasan Mengenai Pola Pikir yang Berkembang",
            "position" => 2,
        ]);

        CourseSection::create([
            "course_id" => 3,
            "title" => "6 Hambatan Pola Pikir yang Berkembang",
            "position" => 3,
        ]);

        CourseSection::create([
            "course_id" => 4,
            "title" => "Pengenalan",
            "position" => 1,
        ]);

        CourseSection::create([
            "course_id" => 4,
            "title" => "Ringkasan Mengenai Pola Pikir yang Berkembang",
            "position" => 2,
        ]);

        CourseSection::create([
            "course_id" => 4,
            "title" => "6 Hambatan Pola Pikir yang Berkembang",
            "position" => 3,
        ]);

        CourseSection::create([
            "course_id" => 5,
            "title" => "Pengenalan",
            "position" => 1,
        ]);

        CourseSection::create([
            "course_id" => 5,
            "title" => "Ringkasan Mengenai Pola Pikir yang Berkembang",
            "position" => 2,
        ]);

        CourseSection::create([
            "course_id" => 5,
            "title" => "6 Hambatan Pola Pikir yang Berkembang",
            "position" => 3,
        ]);
    }
}
