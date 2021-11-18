<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used all in application where need to
    | translate messages that we need to display to the user.
    |
    */

    'add' => 'เพิ่ม',
    'cancel' => 'ยกเลิก',
    'close' => 'ปิด',
    'confirm' => 'ยืนยัน',
    'delete' => 'ลบ',
    'details' => 'รายละเอียด',
    'edit' => 'แก้ไข',
    'id' => 'ไอดี',
    'image' => 'รูปภาพ',
    'image.select' => 'เลือกรูปภาพ',
    'logout' => 'ออกจากระบบ',
    'name' => 'ชื่อ',
    'number' => 'ลำดับ',
    'ok' => 'ตกลง',
    'password' => 'รหัสผ่าน',
    'profile' => 'โปรไฟล์',
    'save' => 'บันทึก',
    'search' => 'ค้นหา',
    'select' => 'เลือก',
    'status' => 'สถานะ',
    'you' => 'คุณ',

    'claim' => 'ซ่อม',
    'claims' => [
        'id' => 'เลขที่เคลม',
        'history' => 'ประวัติการเคลม',
        'problem' => 'อาการที่พบ',
        'applicant' => 'ผู้แจ้งเรื่อง',
        'recipient' => 'ผู้รับเรื่อง',
        'issue-date' => 'แจ้งเมื่อ',
        'accept' => 'รับเรื่อง',
        'claimed' => 'ซ่อมแล้ว',
        'mark-claimed' => 'ทำเครื่องหมายว่าซ่อมแล้ว',
    ],

    'transfer' => 'ย้ายแผนก',
    'transfers' => [
        'from' => 'จากแผนก',
        'to' => 'ไปแผนก',
        'applicant' => 'ผู้แจ้งเรื่อง',
        'issue-date' => 'แจ้งเมื่อ',
        'accept' => 'รับเรื่อง',
    ],

    'equipment' => 'อุปกรณ์',
    'equipments' => [
        'model' => 'รุ่น',
        'serial' => 'เลขครุภัณฑ์',
        'type' => 'ประเภท',
        'brand' => 'ยี่ห้อ',
    ],

    'modal' => [
        'title-warning' => 'คำเตือน',
        'title-error' => 'ข้อผิดพลาด',
        'title-delete' => 'ลบ :name',
        'title-claim-delete' => 'ลบรายการเคลม',
        'msg-delete' => 'ต้องการที่จะลบ :name หรือไม่?',
        'msg-claim-delete' => 'ต้องการที่จะลบรายการเคลม :claim หรือไม่?',
        'msg-confirm-role' => 'ต้องการเปลี่ยนบัญชี :user เป็น:roleหรือไม่?',
        'msg-confirm-extra' => 'เพื่อความปลอดภัย, กรุณายืนยันรหัสผ่าน',
        'msg-error-inuse' => 'ไม่สามารถลบได้เนื่องจากถูกใช้งานอยู่',
        'msg-warn-username-change' => 'ควรเปลี่ยนเฉพาะเหตุจำเป็นเท่านั้น',
    ],

    'nav' => [
        'dashboard' => 'หน้าหลัก',
        'control' => 'หน้าควบคุม',
        'profile' => 'โปรไฟล์',
    ],

    'department' => 'หน่วยงาน',
    'departments' => [
        'name' => 'ชื่อหน่วยงาน',
    ],

    'role' => 'สถานะ',
    'roles' => [
        'admin' => 'ผู้ดูแลระบบ',
        'member' => 'ผู้ใช้ทั่วไป',
        'switch' => [
            'admin' => 'เปลี่ยนเป็นผู้ดูแลระบบ',
            'member' => 'เปลี่ยนเป็นผู้ใช้ทั่วไป',
        ],
    ],

    'sub-department' => 'แผนก',
    'sub-departments' => [
        'add' =>'เพิ่มแผนก',
        'also' =>'แผนกที่จะถูกลบไปด้วย',
        'name' => 'ชื่อแผนก',
    ],

    'tab' => [
        'requests' => 'รอดำเนินการ',
        'claims' => 'รายการเคลมอุปกรณ์',
        'equipments' => 'รายการอุปกรณ์',
        'departments' => 'หน่วยงานและแผนก',
        'accounts' => 'จัดการบัญชีผู้ใช้และแอดมิน',
     ],

    'user' => 'ผู้ใช้',
    'users' => [
        'title' => 'คำนำหน้า',
        'name' => 'ชื่อ',
        'username' => 'ชื่อผู้ใช้',
        'lastname' => 'นามสกุล',
        'email' => 'อีเมล',
        'identification' => 'เลขบัตรประชาชน',
        'sex' => 'เพศ',
        'sexes' => [
            'none' => 'ไม่ระบุ',
            'male' => 'ชาย',
            'female' => 'หญิง',
        ],
    ],

    'validation' => [
        'wrong-password' => 'รหัสผ่านไม่ถูกต้อง',
        'invalid-identify' => 'รูปแบบเลขบัตรประชาชนไม่ถูกต้อง',
        'username-disabled' => ':Attribute ไม่สามาเปลี่ยนได้ชั่วคราว',
     ],
];
