<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-site-settings';

    protected static ?string $navigationLabel = 'إعدادات الموقع';

    protected static ?string $title = 'إعدادات الموقع';

    protected static ?string $navigationGroup = 'الموقع';

    protected static ?int $navigationSort = 2;

    /** @var list<string> */
    protected array $settingKeys = [
        'site_tagline',
        'hero_title',
        'hero_subtitle',
        'about_title',
        'about_body',
        'vision',
        'mission',
        'phone',
        'email',
        'address',
        'address_en',
        'map_query',
        'whatsapp',
        'whatsapp_display',
        'facebook_url',
        'instagram_url',
        'footer_text',
        'footer_designed_by',
        'footer_designer_name',
        'preloader_welcome',
        'website_url',
        'intro_eyebrow',
        'intro_title',
        'intro_p1',
        'intro_p2',
        'intro_p3',
        'intro_p4',
        'intro_float_label',
        'intro_float_value',
        'intro_trust_exp',
        'intro_trust_exp_sub',
        'intro_trust_speed',
        'intro_trust_speed_sub',
        'intro_trust_commit',
        'intro_trust_commit_sub',
        'intro_tags',
        'intro_image',
        'services_eyebrow',
        'services_title',
        'services_lead',
        'goals_eyebrow',
        'goals_title',
        'goals_subtitle',
        'why_eyebrow',
        'why_title',
        'why_lead',
        'clients_eyebrow',
        'clients_title',
        'clients_lead',
        'clients_count_label',
        'clients_sectors',
        'clients_sectors_sub',
        'clients_partnership',
        'clients_partnership_sub',
        'partners_eyebrow',
        'partners_title',
        'partners_lead',
        'partners_seal',
        'partners_label',
        'contact_eyebrow',
        'contact_title',
        'contact_lead',
        'cta_consult',
        'cta_view_services',
        'cta_contact_us',
        'cta_contact_now',
        'cta_request_service',
    ];

    public ?array $data = [];

    public function mount(): void
    {
        $fill = [];

        foreach ($this->settingKeys as $key) {
            $fill[$key] = Setting::get($key);
        }

        $this->form->fill($fill);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('الإعدادات')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('عامة')
                            ->schema([
                                Forms\Components\TextInput::make('site_tagline')->label('الشعار الفرعي'),
                                Forms\Components\TextInput::make('website_url')->label('الموقع الإلكتروني')->placeholder('mwatheeq.com'),
                                Forms\Components\TextInput::make('preloader_welcome')->label('نص شاشة التحميل'),
                                Forms\Components\Textarea::make('footer_text')->label('نص التذييل')->rows(2),
                                Forms\Components\TextInput::make('footer_designed_by')->label('تسمية مصمم الفوتر'),
                                Forms\Components\TextInput::make('footer_designer_name')->label('اسم مصمم الفوتر'),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('السلايدر')
                            ->schema([
                                Forms\Components\TextInput::make('hero_title')->label('عنوان احتياطي للسلايدر'),
                                Forms\Components\Textarea::make('hero_subtitle')->label('وصف الميتا / السلايدر')->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('تعرف علينا')
                            ->schema([
                                Forms\Components\TextInput::make('intro_eyebrow')->label('العنوان الصغير'),
                                Forms\Components\TextInput::make('intro_title')->label('العنوان الرئيسي')->columnSpanFull(),
                                Forms\Components\Textarea::make('intro_p1')->label('الفقرة 1')->rows(3)->columnSpanFull(),
                                Forms\Components\Textarea::make('intro_p2')->label('الفقرة 2')->rows(3)->columnSpanFull(),
                                Forms\Components\Textarea::make('intro_p3')->label('الفقرة 3')->rows(3)->columnSpanFull(),
                                Forms\Components\Textarea::make('intro_p4')->label('الفقرة 4')->rows(2)->columnSpanFull(),
                                Forms\Components\Textarea::make('intro_tags')
                                    ->label('الوسوم')
                                    ->helperText('كل وسم في سطر مستقل')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('intro_float_label')->label('تسمية البطاقة العائمة'),
                                Forms\Components\TextInput::make('intro_float_value')->label('قيمة البطاقة العائمة'),
                                Forms\Components\TextInput::make('intro_trust_exp')->label('ثقة 1 — العنوان'),
                                Forms\Components\TextInput::make('intro_trust_exp_sub')->label('ثقة 1 — الوصف'),
                                Forms\Components\TextInput::make('intro_trust_speed')->label('ثقة 2 — العنوان'),
                                Forms\Components\TextInput::make('intro_trust_speed_sub')->label('ثقة 2 — الوصف'),
                                Forms\Components\TextInput::make('intro_trust_commit')->label('ثقة 3 — العنوان'),
                                Forms\Components\TextInput::make('intro_trust_commit_sub')->label('ثقة 3 — الوصف'),
                                Forms\Components\TextInput::make('intro_image')
                                    ->label('مسار صورة القسم')
                                    ->helperText('مثال: image/sections/intro.jpg')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('عناوين الأقسام')
                            ->schema([
                                Forms\Components\Section::make('الخدمات')->schema([
                                    Forms\Components\TextInput::make('services_eyebrow')->label('عنوان صغير'),
                                    Forms\Components\TextInput::make('services_title')->label('العنوان'),
                                    Forms\Components\Textarea::make('services_lead')->label('الوصف')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                                Forms\Components\Section::make('الأهداف')->schema([
                                    Forms\Components\TextInput::make('goals_eyebrow')->label('عنوان صغير'),
                                    Forms\Components\TextInput::make('goals_title')->label('العنوان'),
                                    Forms\Components\Textarea::make('goals_subtitle')->label('الوصف')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                                Forms\Components\Section::make('لماذا تختارنا')->schema([
                                    Forms\Components\TextInput::make('why_eyebrow')->label('عنوان صغير'),
                                    Forms\Components\TextInput::make('why_title')->label('العنوان'),
                                    Forms\Components\Textarea::make('why_lead')->label('الوصف')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                                Forms\Components\Section::make('عملاؤنا')->schema([
                                    Forms\Components\TextInput::make('clients_eyebrow')->label('عنوان صغير'),
                                    Forms\Components\TextInput::make('clients_title')->label('العنوان'),
                                    Forms\Components\Textarea::make('clients_lead')->label('الوصف')->rows(2)->columnSpanFull(),
                                    Forms\Components\TextInput::make('clients_count_label')->label('تسمية العدد'),
                                    Forms\Components\TextInput::make('clients_sectors')->label('قطاعات — العنوان'),
                                    Forms\Components\TextInput::make('clients_sectors_sub')->label('قطاعات — الوصف'),
                                    Forms\Components\TextInput::make('clients_partnership')->label('شراكة — العنوان'),
                                    Forms\Components\TextInput::make('clients_partnership_sub')->label('شراكة — الوصف'),
                                ])->columns(2),
                                Forms\Components\Section::make('الجهات')->schema([
                                    Forms\Components\TextInput::make('partners_eyebrow')->label('عنوان صغير'),
                                    Forms\Components\TextInput::make('partners_title')->label('العنوان'),
                                    Forms\Components\Textarea::make('partners_lead')->label('الوصف')->rows(2)->columnSpanFull(),
                                    Forms\Components\TextInput::make('partners_seal')->label('ختم العدد'),
                                    Forms\Components\TextInput::make('partners_label')->label('تسمية الجهة'),
                                ])->columns(2),
                                Forms\Components\Section::make('التواصل (عناوين)')->schema([
                                    Forms\Components\TextInput::make('contact_eyebrow')->label('عنوان صغير'),
                                    Forms\Components\TextInput::make('contact_title')->label('العنوان'),
                                    Forms\Components\Textarea::make('contact_lead')->label('الوصف')->rows(2)->columnSpanFull(),
                                ])->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('من نحن')
                            ->schema([
                                Forms\Components\TextInput::make('about_title')->label('عنوان قسم من نحن'),
                                Forms\Components\Textarea::make('about_body')->label('نص من نحن')->rows(5)->columnSpanFull(),
                                Forms\Components\Textarea::make('vision')->label('رؤيتنا')->rows(3),
                                Forms\Components\Textarea::make('mission')->label('رسالتنا')->rows(3),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('أزرار CTA')
                            ->schema([
                                Forms\Components\TextInput::make('cta_consult')->label('اطلب استشارة'),
                                Forms\Components\TextInput::make('cta_view_services')->label('استعرض خدماتنا'),
                                Forms\Components\TextInput::make('cta_contact_us')->label('تواصل معنا'),
                                Forms\Components\TextInput::make('cta_contact_now')->label('تواصل معنا الآن'),
                                Forms\Components\TextInput::make('cta_request_service')->label('اطلب خدمة الآن'),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('التواصل')
                            ->schema([
                                Forms\Components\TextInput::make('phone')->label('رقم الهاتف')->tel(),
                                Forms\Components\TextInput::make('email')->label('البريد الإلكتروني')->email(),
                                Forms\Components\TextInput::make('whatsapp')->label('واتساب (رابط)')->helperText('رقم دولي بدون رموز، مثال: 2010xxxxxxxx'),
                                Forms\Components\TextInput::make('whatsapp_display')->label('رقم واتساب للعرض')->helperText('يظهر في زر الواتساب العائم'),
                                Forms\Components\TextInput::make('facebook_url')->label('رابط فيسبوك')->url(),
                                Forms\Components\TextInput::make('instagram_url')->label('رابط إنستجرام')->url(),
                                Forms\Components\Textarea::make('address')->label('العنوان (عربي)')->rows(2),
                                Forms\Components\Textarea::make('address_en')->label('العنوان (إنجليزي)')->rows(2),
                                Forms\Components\TextInput::make('map_query')->label('موقع الخريطة')->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('تم حفظ الإعدادات بنجاح')
            ->success()
            ->send();
    }
}
