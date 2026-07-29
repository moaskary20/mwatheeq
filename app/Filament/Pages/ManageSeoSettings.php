<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSeoSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static string $view = 'filament.pages.manage-seo-settings';

    protected static ?string $navigationLabel = 'إعدادات الـ SEO';

    protected static ?string $title = 'إعدادات الـ SEO';

    protected static ?string $navigationGroup = 'الموقع';

    protected static ?int $navigationSort = 9;

    /** @var list<string> */
    protected array $settingKeys = [
        'seo_focus_keyword',
        'seo_meta_title',
        'seo_meta_description',
        'seo_meta_keywords',
        'seo_canonical_url',
        'seo_robots',
        'seo_author',
        'seo_og_title',
        'seo_og_description',
        'seo_og_image',
        'seo_og_type',
        'seo_og_site_name',
        'seo_twitter_card',
        'seo_twitter_title',
        'seo_twitter_description',
        'seo_twitter_image',
        'seo_google_verification',
        'seo_bing_verification',
        'seo_yandex_verification',
        'seo_google_analytics_id',
        'seo_google_tag_id',
        'seo_google_tag_manager_id',
        'seo_google_ads_id',
        'seo_facebook_pixel_id',
        'seo_facebook_domain_verification',
        'seo_schema_org_name',
        'seo_schema_org_logo',
        'seo_schema_org_type',
        'seo_schema_phone',
        'seo_schema_email',
        'seo_schema_address',
        'seo_schema_city',
        'seo_schema_region',
        'seo_schema_postal_code',
        'seo_schema_country',
        'seo_schema_lat',
        'seo_schema_lng',
        'seo_schema_same_as',
        'seo_hreflang_ar',
        'seo_hreflang_en',
        'seo_hreflang_x_default',
        'seo_sitemap_url',
        'seo_theme_color',
        'seo_custom_head',
        'seo_robots_txt',
        'seo_noindex_site',
    ];

    public ?array $data = [];

    public function mount(): void
    {
        $fill = [];

        foreach ($this->settingKeys as $key) {
            $value = Setting::get($key);

            if ($key === 'seo_noindex_site') {
                $fill[$key] = $value === '1' || $value === 1 || $value === true;
                continue;
            }

            $fill[$key] = $value;
        }

        $this->form->fill($fill);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('seo')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('أساسي')
                            ->schema([
                                Forms\Components\TextInput::make('seo_focus_keyword')
                                    ->label('Focus Keyword')
                                    ->helperText('الكلمة المفتاحية الأساسية لترتيب الموقع (مهم لجوجل).')
                                    ->maxLength(120)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_meta_title')
                                    ->label('عنوان الصفحة (Meta Title)')
                                    ->helperText('يفضّل 50–60 حرفًا، ويُستحسن تضمين الـ Focus Keyword.')
                                    ->maxLength(70)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_meta_description')
                                    ->label('وصف الصفحة (Meta Description)')
                                    ->helperText('يفضّل 140–160 حرفًا.')
                                    ->rows(3)
                                    ->maxLength(180)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_meta_keywords')
                                    ->label('الكلمات المفتاحية')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_canonical_url')
                                    ->label('Canonical URL')
                                    ->url()
                                    ->placeholder('https://mwatheeq.com'),
                                Forms\Components\Select::make('seo_robots')
                                    ->label('Robots')
                                    ->options([
                                        'index,follow' => 'index, follow (موصى به)',
                                        'index,nofollow' => 'index, nofollow',
                                        'noindex,follow' => 'noindex, follow',
                                        'noindex,nofollow' => 'noindex, nofollow',
                                    ])
                                    ->default('index,follow'),
                                Forms\Components\TextInput::make('seo_author')
                                    ->label('Author')
                                    ->maxLength(120),
                                Forms\Components\TextInput::make('seo_theme_color')
                                    ->label('Theme Color')
                                    ->placeholder('#3154ad')
                                    ->helperText('لون شريط المتصفح على الموبايل.'),
                                Forms\Components\TextInput::make('seo_sitemap_url')
                                    ->label('رابط Sitemap')
                                    ->url()
                                    ->placeholder(url('/sitemap.xml'))
                                    ->helperText('يُذكر داخل robots.txt ويساعد جوجل على الزحف.'),
                                Forms\Components\Toggle::make('seo_noindex_site')
                                    ->label('إخفاء الموقع بالكامل عن الفهرسة')
                                    ->inline(false)
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('Google')
                            ->schema([
                                Forms\Components\Section::make('التحقق من الملكية')
                                    ->schema([
                                        Forms\Components\TextInput::make('seo_google_verification')
                                            ->label('Google Search Console Verification')
                                            ->helperText('قيمة content من وسم google-site-verification فقط.')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('seo_bing_verification')
                                            ->label('Bing Verification'),
                                        Forms\Components\TextInput::make('seo_yandex_verification')
                                            ->label('Yandex Verification'),
                                    ])->columns(2),
                                Forms\Components\Section::make('Google Tag & Analytics')
                                    ->description('ضع معرّفات التتبع الخاصة بجوجل. يمكن استخدام أكثر من حقل معًا.')
                                    ->schema([
                                        Forms\Components\TextInput::make('seo_google_tag_id')
                                            ->label('Google Tag ID')
                                            ->placeholder('GT-XXXXXXX أو G-XXXXXXXX')
                                            ->helperText('معرّف Google Tag الرسمي من حسابك في Google.')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('seo_google_analytics_id')
                                            ->label('Google Analytics (GA4)')
                                            ->placeholder('G-XXXXXXXXXX'),
                                        Forms\Components\TextInput::make('seo_google_ads_id')
                                            ->label('Google Ads / Conversion ID')
                                            ->placeholder('AW-XXXXXXXXX')
                                            ->helperText('لتحويلات إعلانات جوجل.'),
                                        Forms\Components\TextInput::make('seo_google_tag_manager_id')
                                            ->label('Google Tag Manager (GTM)')
                                            ->placeholder('GTM-XXXXXXX')
                                            ->columnSpanFull(),
                                    ])->columns(2),
                                Forms\Components\Section::make('Hreflang (اللغات)')
                                    ->description('مهم لجوجل عند وجود نسخة عربية وإنجليزية.')
                                    ->schema([
                                        Forms\Components\TextInput::make('seo_hreflang_ar')
                                            ->label('رابط النسخة العربية (hreflang=ar)')
                                            ->url()
                                            ->placeholder(url('/')),
                                        Forms\Components\TextInput::make('seo_hreflang_en')
                                            ->label('رابط النسخة الإنجليزية (hreflang=en)')
                                            ->url(),
                                        Forms\Components\TextInput::make('seo_hreflang_x_default')
                                            ->label('x-default')
                                            ->url()
                                            ->helperText('الصفحة الافتراضية لمحركات البحث عند عدم تطابق اللغة.'),
                                    ])->columns(1),
                            ]),
                        Forms\Components\Tabs\Tab::make('Facebook Pixel')
                            ->schema([
                                Forms\Components\TextInput::make('seo_facebook_pixel_id')
                                    ->label('Facebook Pixel ID')
                                    ->placeholder('XXXXXXXXXXXXXXXX')
                                    ->helperText('رقم الـ Pixel من Meta Events Manager.')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_facebook_domain_verification')
                                    ->label('Facebook Domain Verification')
                                    ->helperText('قيمة content من وسم facebook-domain-verification إن وُجدت.')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Open Graph')
                            ->schema([
                                Forms\Components\TextInput::make('seo_og_title')
                                    ->label('og:title')
                                    ->maxLength(70)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_og_description')
                                    ->label('og:description')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('seo_og_image')
                                    ->label('og:image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->helperText('يفضّل 1200×630 بكسل.')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('seo_og_type')
                                    ->label('og:type')
                                    ->options([
                                        'website' => 'website',
                                        'article' => 'article',
                                        'business.business' => 'business',
                                    ])
                                    ->default('website'),
                                Forms\Components\TextInput::make('seo_og_site_name')
                                    ->label('og:site_name')
                                    ->maxLength(120),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('Twitter')
                            ->schema([
                                Forms\Components\Select::make('seo_twitter_card')
                                    ->label('نوع البطاقة')
                                    ->options([
                                        'summary' => 'summary',
                                        'summary_large_image' => 'summary_large_image',
                                    ])
                                    ->default('summary_large_image'),
                                Forms\Components\TextInput::make('seo_twitter_title')
                                    ->label('عنوان Twitter')
                                    ->maxLength(70)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_twitter_description')
                                    ->label('وصف Twitter')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('seo_twitter_image')
                                    ->label('صورة Twitter')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->visibility('public')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Local SEO / Schema')
                            ->schema([
                                Forms\Components\TextInput::make('seo_schema_org_name')
                                    ->label('اسم المنظمة / النشاط')
                                    ->maxLength(160),
                                Forms\Components\Select::make('seo_schema_org_type')
                                    ->label('نوع Schema')
                                    ->options([
                                        'Organization' => 'Organization',
                                        'LocalBusiness' => 'LocalBusiness',
                                        'ProfessionalService' => 'ProfessionalService',
                                    ])
                                    ->default('ProfessionalService'),
                                Forms\Components\FileUpload::make('seo_schema_org_logo')
                                    ->label('شعار Schema')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->visibility('public')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_schema_phone')
                                    ->label('هاتف النشاط')
                                    ->tel(),
                                Forms\Components\TextInput::make('seo_schema_email')
                                    ->label('بريد النشاط')
                                    ->email(),
                                Forms\Components\Textarea::make('seo_schema_address')
                                    ->label('العنوان التفصيلي')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_schema_city')
                                    ->label('المدينة')
                                    ->placeholder('الإسكندرية'),
                                Forms\Components\TextInput::make('seo_schema_region')
                                    ->label('المحافظة / المنطقة'),
                                Forms\Components\TextInput::make('seo_schema_postal_code')
                                    ->label('الرمز البريدي'),
                                Forms\Components\TextInput::make('seo_schema_country')
                                    ->label('الدولة')
                                    ->placeholder('EG')
                                    ->helperText('رمز الدولة بحرفين، مثال: EG'),
                                Forms\Components\TextInput::make('seo_schema_lat')
                                    ->label('خط العرض (Latitude)'),
                                Forms\Components\TextInput::make('seo_schema_lng')
                                    ->label('خط الطول (Longitude)'),
                                Forms\Components\Textarea::make('seo_schema_same_as')
                                    ->label('روابط Social / sameAs')
                                    ->helperText('كل رابط في سطر (فيسبوك، إنستجرام، خرائط جوجل...). يقوّي Knowledge Graph.')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('متقدم')
                            ->schema([
                                Forms\Components\Textarea::make('seo_robots_txt')
                                    ->label('محتوى robots.txt')
                                    ->rows(10)
                                    ->helperText('يظهر على /robots.txt')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_custom_head')
                                    ->label('كود مخصص داخل <head>')
                                    ->rows(8)
                                    ->helperText('لصق سكربتات تحقق أو أكواد إضافية بحذر.')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }

            if (is_array($value)) {
                $value = collect($value)->filter()->first() ?? '';
            }

            Setting::set($key, $value ?? '');
        }

        Notification::make()
            ->title('تم حفظ إعدادات الـ SEO بنجاح')
            ->success()
            ->send();
    }
}
