<?php
namespace App\Helpers;
class TypeHelper
{
    public static $types = [
        'technical_issues' => 'task_tech_db',
        'account_billing' => 'task_accounts_db',
        'product_service' => 'task_sales_db',
        'general_inquiry' => 'task_inquiry_db',
        'feedback' => 'task_feedback_db',
    ];

    public static function getDatabaseForType($type)
    {
        return self::$types[$type] ?? null;
    }

    public static function getAllTypes()
    {
        return self::$types;
    }
}