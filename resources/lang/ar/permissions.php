<?php


return [

    'roles' => [
        'name' => 'الصلاحيات',
        'perm' => [
            'manage_roles' => 'إدارة الأدوار والصلاحيات',
        ]
    ],
    'admins' => [
        'name' => 'المدراء',
        'perm' => [
            'add_admins' => 'اضافة مدير',
            'show_admins' => 'عرض مدير',
        ]
    ],
    'students' => [
        'name' => 'الطلاب',
        'perm' => [
            'add_students' => 'إضافة طلاب',
            'show_students' => 'عرض الطلاب',
            'delete_students' => 'حذف طلاب',
        ]
    ],
    'teachers' => [
        'name' => 'المدرسين',
        'perm' => [
            'add_teachers' => 'إضافة مدرسين',
            'show_teachers' => 'عرض المدرسين',
            'delete_teachers' => 'حذف مدرسين',
        ]
    ],
    'help_center' => [
        'name' => 'إدارة مركز المساعدة',
        'perm' => [
            'manage_inbox' => 'إدارة صندوق الوارد',
            'manage_message_types' => 'إدارة أنواع رسائل التواصل',
        ]
    ],
    'constants' => [
        'name' => 'ثوابت الموقع',
        'perm' => [
            'manage_pages' => 'إدارة صفحات الموقع',
            'manage_blogs' => 'إدارة المقالات',
            'manage_faq' => 'إدارة الأسئلة الشائعة',
            'manage_settings' => 'إدارة الإعدادات',
            'manage_library' => 'إدارة المكتبة',
            'manage_materials' => 'إدارة المواد التعليمية',
            'manage_academic_levels' => 'إدارة المستوى الدراسي',
            'manage_countries' => 'إدارة الدول',
        ]
    ],

];

