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
        'seo_google_analytics_id',
        'seo_google_tag_manager_id',
        'seo_schema_org_name',
        'seo_schema_org_logo',
        'seo_schema_org_type',
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
                                    ->helperText('الكلمة المفتاحية الأساسية التي تريد ترتيب الموقع عليها (مثال: خدمات حكومية الإسكندرية).')
                                    ->maxLength(120)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_meta_title')
                                    ->label('عنوان الصفحة (Meta Title)')
                                    ->helperText('يفضّل 50–60 حرفًا، ويُستحسن تضمين الـ Focus Keyword.')
                                    ->maxLength(70)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_meta_description')
                                    ->label('وصف الصفحة (Meta Description)')
                                    ->helperText('يفضّل 140–160 حرفًا، ويُستحسن تضمين الـ Focus Keyword.')
                                    ->rows(3)
                                    ->maxLength(180)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_meta_keywords')
                                    ->label('الكلمات المفتاحية (Meta Keywords)')
                                    ->helperText('افصل بين الكلمات بفاصلة. يمكن تضمين الـ Focus Keyword هنا أيضًا.')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_canonical_url')
                                    ->label('الرابط الأساسي (Canonical URL)')
                                    ->url()
                                    ->placeholder('https://mwatheeq.com')
                                    ->helperText('اتركه فارغًا لاستخدام رابط الصفحة الحالية.'),
                                Forms\Components\Select::make('seo_robots')
                                    ->label('توجيه محركات البحث (Robots)')
                                    ->options([
                                        'index,follow' => 'index, follow (موصى به)',
                                        'index,nofollow' => 'index, nofollow',
                                        'noindex,follow' => 'noindex, follow',
                                        'noindex,nofollow' => 'noindex, nofollow',
                                    ])
                                    ->default('index,follow'),
                                Forms\Components\TextInput::make('seo_author')
                                    ->label('المؤلف (Author)')
                                    ->maxLength(120),
                                Forms\Components\Toggle::make('seo_noindex_site')
                                    ->label('إخفاء الموقع بالكامل عن الفهرسة')
                                    ->helperText('عند التفعيل يُضاف noindex لكل الصفحات (مفيد أثناء التطوير).')
                                    ->inline(false)
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('Open Graph')
                            ->schema([
                                Forms\Components\TextInput::make('seo_og_title')
                                    ->label('عنوان المشاركة (og:title)')
                                    ->maxLength(70)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('seo_og_description')
                                    ->label('وصف المشاركة (og:description)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('seo_og_image')
                                    ->label('صورة المشاركة (og:image)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->helperText('يفضّل 1200×630 بكسل.')
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('seo_og_type')
                                    ->label('نوع المحتوى (og:type)')
                                    ->options([
                                        'website' => 'website',
                                        'article' => 'article',
                                        'business.business' => 'business',
                                    ])
                                    ->default('website'),
                                Forms\Components\TextInput::make('seo_og_site_name')
                                    ->label('اسم الموقع (og:site_name)')
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
                                    ->helperText('إن تُركت فارغة تُستخدم صورة Open Graph.')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Tabs\Tab::make('تحليلات وتحقق')
                            ->schema([
                                Forms\Components\TextInput::make('seo_google_verification')
                                    ->label('Google Search Console Verification')
                                    ->helperText('قيمة content من وسم google-site-verification فقط.')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_bing_verification')
                                    ->label('Bing Webmaster Verification')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('seo_google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX'),
                                Forms\Components\TextInput::make('seo_google_tag_manager_id')
                                    ->label('Google Tag Manager ID')
                                    ->placeholder('GTM-XXXXXXX'),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('Schema / Organization')
                            ->schema([
                                Forms\Components\TextInput::make('seo_schema_org_name')
                                    ->label('اسم المنظمة')
                                    ->maxLength(160),
                                Forms\Components\Select::make('seo_schema_org_type')
                                    ->label('نوع Schema')
                                    ->options([
                                        'Organization' => 'Organization',
                                        'LocalBusiness' => 'LocalBusiness',
                                        'ProfessionalService' => 'ProfessionalService',
                                    ])
                                    ->default('Organization'),
                                Forms\Components\FileUpload::make('seo_schema_org_logo')
                                    ->label('شعار المنظمة (Schema)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->visibility('public')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Tabs\Tab::make('robots.txt')
                            ->schema([
                                Forms\Components\Textarea::make('seo_robots_txt')
                                    ->label('محتوى robots.txt')
                                    ->rows(12)
                                    ->helperText('يظهر على الرابط /robots.txt')
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
