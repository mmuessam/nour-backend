<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\HelpCase;
use App\Models\Donation;
use App\Models\CaseUpdate;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- USERS ----
        $admin = User::create([
            'name'     => 'أحمد محمد السيد',
            'email'    => 'admin@nour.org',
            'password' => Hash::make('123456'),
            'role'     => 'superadmin',
            'avatar'   => 'أم',
            'color'    => '#16A34A',
        ]);
        $fatima = User::create([
            'name'     => 'فاطمة عبدالله',
            'email'    => 'fatima@nour.org',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
            'avatar'   => 'فع',
            'color'    => '#7C3AED',
        ]);
        $mohammed = User::create([
            'name'     => 'محمد إبراهيم',
            'email'    => 'mohammed@nour.org',
            'password' => Hash::make('123456'),
            'role'     => 'assistant',
            'avatar'   => 'مإ',
            'color'    => '#2563EB',
        ]);
        $noura = User::create([
            'name'     => 'نورة الأحمدي',
            'email'    => 'noura@nour.org',
            'password' => Hash::make('123456'),
            'role'     => 'volunteer',
            'avatar'   => 'نأ',
            'color'    => '#D97706',
        ]);

        // ---- CATEGORIES ----
        $categories = [
            ['slug'=>'medical',    'name'=>'الحالات الطبية',   'icon'=>'🏥','color'=>'#DC2626','bg'=>'#FEE2E2','target'=>2100000],
            ['slug'=>'education',  'name'=>'الدعم التعليمي',   'icon'=>'📚','color'=>'#2563EB','bg'=>'#DBEAFE','target'=>750000],
            ['slug'=>'food',       'name'=>'مساعدات غذائية',   'icon'=>'🍱','color'=>'#16A34A','bg'=>'#DCFCE7','target'=>800000],
            ['slug'=>'housing',    'name'=>'دعم السكن',         'icon'=>'🏠','color'=>'#7C3AED','bg'=>'#EDE9FE','target'=>1400000],
            ['slug'=>'emergency',  'name'=>'إغاثة طارئة',       'icon'=>'🚨','color'=>'#EA580C','bg'=>'#FFEDD5','target'=>900000],
            ['slug'=>'sponsorship','name'=>'كفالة شهرية',       'icon'=>'💚','color'=>'#0D9488','bg'=>'#CCFBF1','target'=>3000000],
            ['slug'=>'debt',       'name'=>'قضاء الديون',       'icon'=>'💰','color'=>'#B45309','bg'=>'#FEF3C7','target'=>500000],
            ['slug'=>'orphan',     'name'=>'كفالة الأيتام',     'icon'=>'👶','color'=>'#BE185D','bg'=>'#FCE7F3','target'=>2000000],
            ['slug'=>'seasonal',   'name'=>'حملات موسمية',      'icon'=>'🌙','color'=>'#0369A1','bg'=>'#E0F2FE','target'=>1200000],
            ['slug'=>'general',    'name'=>'تبرعات عامة',       'icon'=>'🤲','color'=>'#4B5563','bg'=>'#F1F5F9','target'=>1000000],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $medical  = Category::where('slug','medical')->first();
        $housing  = Category::where('slug','housing')->first();
        $education= Category::where('slug','education')->first();
        $food     = Category::where('slug','food')->first();
        $orphan   = Category::where('slug','orphan')->first();
        $debt     = Category::where('slug','debt')->first();

        // ---- CASES ----
        $case1 = HelpCase::create([
            'case_number' => 'NR-2024-0001',
            'title'       => 'علاج طفل من مرض السرطان',
            'category_id' => $medical->id,
            'description' => 'طفل في السابعة من عمره يعاني من سرطان الدم ويحتاج إلى جلسات كيماوي وزراعة نخاع عاجلة.',
            'beneficiary' => 'أ.م.ع',
            'target'      => 180000,
            'collected'   => 142000,
            'status'      => 'urgent',
            'priority'    => 'critical',
            'location'    => 'الرياض',
            'image'       => '🏥',
            'created_by'  => $admin->id,
        ]);
        $case2 = HelpCase::create([
            'case_number' => 'NR-2024-0002',
            'title'       => 'أسرة نازحة تحتاج مأوى',
            'category_id' => $housing->id,
            'description' => 'أسرة مكونة من 7 أفراد نزحت من منطقة النزاع وتسكن في مخيم مؤقت.',
            'beneficiary' => 'خ.ع.م',
            'target'      => 45000,
            'collected'   => 40500,
            'status'      => 'active',
            'priority'    => 'high',
            'location'    => 'جدة',
            'image'       => '🏠',
            'created_by'  => $fatima->id,
        ]);
        $case3 = HelpCase::create([
            'case_number' => 'NR-2024-0003',
            'title'       => 'كفالة طالب موهوب',
            'category_id' => $education->id,
            'description' => 'طالب متفوق يحتاج دعماً لإكمال دراسته الجامعية.',
            'beneficiary' => 'س.أ.ح',
            'target'      => 30000,
            'collected'   => 30000,
            'status'      => 'completed',
            'priority'    => 'medium',
            'location'    => 'الدمام',
            'image'       => '📚',
            'created_by'  => $mohammed->id,
        ]);
        $case4 = HelpCase::create([
            'case_number' => 'NR-2024-0004',
            'title'       => 'سلال غذائية لرمضان',
            'category_id' => $food->id,
            'description' => 'توزيع 500 سلة غذائية على الأسر المحتاجة خلال شهر رمضان.',
            'beneficiary' => 'متعدد',
            'target'      => 75000,
            'collected'   => 68000,
            'status'      => 'active',
            'priority'    => 'high',
            'location'    => 'الرياض',
            'image'       => '🍱',
            'created_by'  => $admin->id,
        ]);

        // ---- DONATIONS ----
        Donation::create(['donation_number'=>'DON-001','case_id'=>$case1->id,'amount'=>50000,'source'=>'organization','source_name'=>'مؤسسة الرحمة الخيرية','method'=>'تحويل بنكي','date'=>'2024-04-10','added_by'=>$admin->id,'notes'=>'تبرع من المؤسسة كاملاً']);
        Donation::create(['donation_number'=>'DON-002','case_id'=>$case1->id,'amount'=>15000,'source'=>'external','source_name'=>'عبدالله المنصور','method'=>'نقدي','date'=>'2024-04-08','added_by'=>$fatima->id,'notes'=>'']);
        Donation::create(['donation_number'=>'DON-003','case_id'=>$case2->id,'amount'=>25000,'source'=>'admin','source_name'=>'إدارة المنصة','method'=>'تحويل بنكي','date'=>'2024-04-07','added_by'=>$admin->id,'notes'=>'من الاحتياطي العام']);
        Donation::create(['donation_number'=>'DON-004','case_id'=>$case4->id,'amount'=>20000,'source'=>'volunteer','source_name'=>'نورة الأحمدي','method'=>'تحويل بنكي','date'=>'2024-04-11','added_by'=>$noura->id,'notes'=>'جمع من أصدقاء']);

        // ---- CASE UPDATES ----
        CaseUpdate::create(['case_id'=>$case1->id,'title'=>'تم تحديد موعد العملية','details'=>'تمكنا من حجز موعد في مستشفى الملك فيصل التخصصي في 20 أبريل 2024.','added_by'=>$admin->id,'emoji'=>'📅']);
        CaseUpdate::create(['case_id'=>$case1->id,'title'=>'استلام تبرع من مؤسسة الرحمة','details'=>'تم استلام مبلغ 50,000 ريال من مؤسسة الرحمة الخيرية.','added_by'=>$fatima->id,'donation_amount'=>50000,'emoji'=>'💰']);
        CaseUpdate::create(['case_id'=>$case4->id,'title'=>'بدء توزيع السلال الغذائية','details'=>'بدأنا اليوم بتوزيع الدفعة الأولى — 150 سلة في الرياض الشرقية.','added_by'=>$noura->id,'emoji'=>'📦']);

        // ---- NOTIFICATIONS ----
        Notification::create(['user_id'=>$admin->id,'text'=>'تم إضافة تبرع جديد بقيمة 50,000 ر.س لحالة علاج طفل من السرطان','is_read'=>false]);
        Notification::create(['user_id'=>$admin->id,'text'=>'حالة "أسرة نازحة تحتاج مأوى" وصلت 90% من الهدف','is_read'=>false]);
        Notification::create(['user_id'=>$admin->id,'text'=>'انضم عضو جديد إلى الفريق: نورة الأحمدي','is_read'=>false]);
        Notification::create(['user_id'=>$admin->id,'text'=>'تم اكتمال حالة "كفالة طالب موهوب" بنجاح','is_read'=>true]);
    }
}
