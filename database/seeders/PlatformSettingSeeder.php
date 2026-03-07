<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlatformSetting;

class PlatformSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'platform_commission',
                'value' => '20',
                'type' => 'int',
                'description' => 'نسبة عمولة المنصة من كل عملية بيع (%)',
            ],
            [
                'key' => 'coin_price_egp',
                'value' => '1',
                'type' => 'string',
                'description' => 'سعر الكوين الواحد مقابل الجنيه المصري',
            ],
            [
                'key' => 'coin_release_delay',
                'value' => '60',
                'type' => 'int',
                'description' => 'وقت تحرير الكوينز للبائع بعد الشراء (بالدقائق)',
            ],
            [
                'key' => 'suspension_threshold',
                'value' => '5',
                'type' => 'int',
                'description' => 'عدد البلاغات التي تؤدي لتعليق الحساب تلقائياً',
            ],
            [
                'key' => 'support_whatsapp',
                'value' => '+201000000000',
                'type' => 'string',
                'description' => 'رقم واتساب الدعم الفني',
            ],
            [
                'key' => 'firebase_api_key',
                'value' => '',
                'type' => 'string',
                'description' => 'Firebase API Key',
            ],
            [
                'key' => 'firebase_project_id',
                'value' => '',
                'type' => 'string',
                'description' => 'Firebase Project ID',
            ],
            [
                'key' => 'firebase_messaging_sender_id',
                'value' => '',
                'type' => 'string',
                'description' => 'Firebase Messaging Sender ID',
            ],
            [
                'key' => 'firebase_app_id',
                'value' => '',
                'type' => 'string',
                'description' => 'Firebase App ID',
            ],
            [
                'key' => 'notifications_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'تفعيل الإشعارات في النظام',
            ],
        ];

        foreach ($settings as $setting) {
            PlatformSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
