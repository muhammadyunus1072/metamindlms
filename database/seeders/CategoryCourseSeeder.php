<?php

namespace Database\Seeders;

use App\Models\CategoryCourse;
use App\Models\GroupCategoryCourse;
use Illuminate\Database\Seeder;

class CategoryCourseSeeder extends Seeder
{

    public function run()
    {
        $group = GroupCategoryCourse::create([
            "name" => "Certification Program (International Certification)",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Meta NLP Practitioner",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Access Personal Genius (APG) / Coaching Genius",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Meta Master NLP Practitioner",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Coaching Mastery",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Identity Compass Consultant",
        ]);

        $group = GroupCategoryCourse::create([
            "name" => "Coaching Skill",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Transformational Coaching to KPI Execution",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Coaching Fundamental",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Coaching Bootcamp for Leadership",
        ]);

        $group = GroupCategoryCourse::create([
            "name" => "Communication Training",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Dynamic Communication",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Mini Workshop Series on Communication",
        ]);

        $group = GroupCategoryCourse::create([
            "name" => "Education Training",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Tentang Pandailah Guruku, Pandailah Muridku",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Roadmap to Success for Teenager",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "Seminar Parenting",
        ]);

        $group = GroupCategoryCourse::create([
            "name" => "Self Development",
        ]);
        CategoryCourse::create([
            "group_category_course_id" => $group->id,
            "name" => "How to Win People's Heart & Mind in Selling",
        ]);
    }
}
