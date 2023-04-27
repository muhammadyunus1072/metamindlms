<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

    private function createView(): string
    {
        return "
            CREATE OR REPLACE VIEW view_course_member AS
            SELECT 
            
            cm.code as code, cm.created_at as created_at,

            c.id as course_id, c.code as course_code, c.title as course_title,
            
            u.id as member_id, u.name as member_name,

            cr.rating as course_review_rating, cr.comment as course_review_comment,

            ifnull(cml.total_lesson, 0) as total_lesson_learned,

            l.total_lesson as total_lesson,

            ROUND((ifnull(cml.total_lesson, 0) / l.total_lesson) * 100, 2) as progress

            from course_members as cm
            left join courses as c on c.id = cm.course_id
            left join users as u on u.id = cm.member_id
            left join course_reviews as cr on cr.course_id = c.id and cr.member_id = u.id
            left join (
                SELECT
                count(cml.id) as total_lesson, c.id as course_id, cml.member_id as member_id
                from course_member_lessons as cml
                left join lessons as l on l.id = cml.lesson_id
                left join course_sections as cs on cs.id = l.course_section_id
                left join courses as c on c.id = cs.course_id
                where cml.is_done = 1
                group by c.id, cml.member_id
            ) as cml on cml.course_id = cm.course_id and cml.member_id = cm.member_id

            left join (
                SELECT
                count(l.id) as total_lesson, c.id as course_id
                from lessons as l
                left join course_sections as cs on cs.id = l.course_section_id
                left join courses as c on c.id = cs.course_id
                group by c.id
            ) as l on l.course_id = cm.course_id

            where cm.deleted_at is null
            ;
        ";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return 'DROP VIEW IF EXISTS view_procurement_pharmacies';
    }
};
