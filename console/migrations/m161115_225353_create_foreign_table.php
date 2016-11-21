<?php

use yii\db\Migration;

/**
 * Handles the creation for table `foreign`.
 */
class m161115_225353_create_foreign_table extends Migration
{
    public function up()
    {
        // department
        $this->createIndex('fk_department_faculty_idx', '{{%department}}', 'faculty_id');
        $this->addForeignKey('fk_department_faculty', '{{%department}}', 'faculty_id', '{{%faculty}}', 'id');

        // group
        $this->createIndex('fk_group_department_idx', '{{%group}}', 'department_id');
        $this->addForeignKey('fk_group_department', '{{%group}}', 'department_id', '{{%department}}', 'id');

        // discipline
        $this->createIndex('fk_discipline_department_idx', '{{%discipline}}', 'department_id');
        $this->addForeignKey('fk_discipline_department', '{{%discipline}}', 'department_id', '{{%department}}', 'id');

        // group_user
        $this->createIndex('fk_user_group_idx', '{{%group_user}}', 'user_id');
        $this->addForeignKey('fk_user_group', '{{%group_user}}', 'user_id', '{{%user}}', 'id');
        $this->createIndex('fk_group_user_idx', '{{%group_user}}', 'group_id');
        $this->addForeignKey('fk_group_user', '{{%group_user}}', 'group_id', '{{%group}}', 'id');

        // discipline_course
        $this->createIndex('fk_discipline_course_idx', '{{%discipline_course}}', 'discipline_id');
        $this->addForeignKey('fk_discipline_course', '{{%discipline_course}}', 'discipline_id', '{{%discipline}}', 'id');
        $this->createIndex('fk_course_discipline_idx', '{{%discipline_course}}', 'course_id');
        $this->addForeignKey('fk_course_discipline', '{{%discipline_course}}', 'course_id', '{{%course}}', 'id');

        // discipline_user
        $this->createIndex('fk_discipline_user_idx', '{{%discipline_user}}', 'discipline_id');
        $this->addForeignKey('fk_discipline_user', '{{%discipline_user}}', 'discipline_id', '{{%discipline}}', 'id');
        $this->createIndex('fk_user_discipline_idx', '{{%discipline_user}}', 'user_id');
        $this->addForeignKey('fk_user_discipline', '{{%discipline_user}}', 'user_id', '{{%user}}', 'id');

        // topic_course
        $this->createIndex('fk_topic_course_idx', '{{%topic_course}}', 'topic_id');
        $this->addForeignKey('fk_topic_course', '{{%topic_course}}', 'topic_id', '{{%topic}}', 'id');
        $this->createIndex('fk_course_topic_idx', '{{%topic_course}}', 'course_id');
        $this->addForeignKey('fk_course_topic', '{{%topic_course}}', 'course_id', '{{%course}}', 'id');

        // workshop
        $this->createIndex('fk_workshop_topic_idx', '{{%workshop}}', 'topic_id');
        $this->addForeignKey('fk_workshop_topic', '{{%workshop}}', 'topic_id', '{{%topic}}', 'id');

        // mark
        $this->createIndex('fk_mark_user_idx', '{{%mark}}', 'user_id');
        $this->addForeignKey('fk_mark_user', '{{%mark}}', 'user_id', '{{%user}}', 'id');
        $this->createIndex('fk_mark_workshop_idx', '{{%mark}}', 'workshop_id');
        $this->addForeignKey('fk_mark_workshop', '{{%mark}}', 'workshop_id', '{{%workshop}}', 'id');

        // message_user
        $this->createIndex('fk_message_to_user_idx', '{{%message}}', 'to_user_id');
        $this->addForeignKey('fk_message_to_user', '{{%message}}', 'to_user_id', '{{%user}}', 'id');
        $this->createIndex('fk_message_from_user_idx', '{{%message}}', 'from_user_id');
        $this->addForeignKey('fk_message_from_user', '{{%message}}', 'from_user_id', '{{%user}}', 'id');

//        // course_group_user
        $this->createIndex('fk_course_group_user_idx', '{{%course_group_user}}', 'course_id');
        $this->addForeignKey('fk_course_group_user', '{{%course_group_user}}', 'course_id', '{{%course}}', 'id');

        $this->createIndex('fk_group_course_group_user_idx', '{{%course_group_user}}', 'group_id');
        $this->addForeignKey('fk_group_course_group_user', '{{%course_group_user}}', 'group_id', '{{%group_user}}', 'group_id');

        $this->createIndex('fk_user_course_group_user_idx', '{{%course_group_user}}', 'user_id');
        $this->addForeignKey('fk_user_course_group_user', '{{%course_group_user}}', 'user_id', '{{%user}}', 'id');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // department
        $this->dropForeignKey('fk_department_faculty', '{{%department}}');
        $this->dropIndex('fk_department_faculty_idx', '{{%department}}');

        // group
        $this->dropForeignKey('fk_group_department', '{{%group}}');
        $this->dropIndex('fk_group_department_idx', '{{%group}}');

        //  discipline
        $this->dropForeignKey('fk_discipline_department', '{{%discipline}}');
        $this->dropIndex('fk_discipline_department_idx', '{{%discipline}}');

        // group_user
        $this->dropForeignKey('fk_user_group', '{{%group_user}}');
        $this->dropIndex('fk_user_group_idx', '{{%group_user}}');
        $this->dropForeignKey('fk_group_user', '{{%group_user}}');
        $this->dropIndex('fk_group_user_idx', '{{%group_user}}');

        // discipline_course
        $this->dropForeignKey('fk_discipline_course', '{{%discipline_course}}');
        $this->dropIndex('fk_discipline_course_idx', '{{%discipline_course}}');
        $this->dropForeignKey('fk_course_discipline', '{{%discipline_course}}');
        $this->dropIndex('fk_course_discipline_idx', '{{%discipline_course}}');

        // discipline_user
        $this->dropForeignKey('fk_discipline_user', '{{%discipline_user}}');
        $this->dropIndex('fk_discipline_user_idx', '{{%discipline_user}}');
        $this->dropForeignKey('fk_user_discipline', '{{%discipline_user}}');
        $this->dropIndex('fk_user_discipline_idx', '{{%discipline_user}}');

        // topic_course
        $this->dropForeignKey('fk_topic_course', '{{%topic_course}}');
        $this->dropIndex('fk_topic_course_idx', '{{%topic_course}}');
        $this->dropForeignKey('fk_course_topic', '{{%topic_course}}');
        $this->dropIndex('fk_course_topic_idx', '{{%topic_course}}');

        // workshop
        $this->dropForeignKey('fk_workshop_topic', '{{%workshop}}');
        $this->dropIndex('fk_workshop_topic_idx', '{{%workshop}}');

        // mark
        $this->dropForeignKey('fk_mark_user', '{{%mark}}');
        $this->dropIndex('fk_mark_user_idx', '{{%mark}}');
        $this->dropForeignKey('fk_mark_workshop', '{{%mark}}');
        $this->dropIndex('fk_mark_workshop_idx', '{{%mark}}');

        // message_user
        $this->dropForeignKey('fk_message_to_user', '{{%message}}');
        $this->dropIndex('fk_message_to_user_idx', '{{%message}}');
        $this->dropForeignKey('fk_message_from_user', '{{%message}}');
        $this->dropIndex('fk_message_from_user_idx', '{{%message}}');

//        // course_group_user
        $this->dropForeignKey('fk_course_group_user', '{{%course_group_user}}');
        $this->dropIndex('fk_course_group_user_idx', '{{%course_group_user}}');
        $this->dropForeignKey('fk_group_course_group_user', '{{%course_group_user}}');
        $this->dropIndex('fk_group_course_group_user_idx', '{{%course_group_user}}');
        $this->dropForeignKey('fk_user_course_group_user', '{{%course_group_user}}');
        $this->dropIndex('fk_user_course_group_user_idx', '{{%course_group_user}}');
    }
}
