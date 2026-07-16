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

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_tagline' => Setting::get('site_tagline'),
            'hero_title' => Setting::get('hero_title'),
            'hero_subtitle' => Setting::get('hero_subtitle'),
            'about_title' => Setting::get('about_title'),
            'about_body' => Setting::get('about_body'),
            'vision' => Setting::get('vision'),
            'mission' => Setting::get('mission'),
            'phone' => Setting::get('phone'),
            'email' => Setting::get('email'),
            'address' => Setting::get('address'),
            'address_en' => Setting::get('address_en'),
            'map_query' => Setting::get('map_query'),
            'whatsapp' => Setting::get('whatsapp'),
            'facebook_url' => Setting::get('facebook_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'footer_text' => Setting::get('footer_text'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('الإعدادات')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('الصفحة الرئيسية')
                            ->schema([
                                Forms\Components\TextInput::make('site_tagline')
                                    ->label('الشعار الفرعي')
                                    ->required(),
                                Forms\Components\TextInput::make('hero_title')
                                    ->label('عنوان القسم الرئيسي')
                                    ->required(),
                                Forms\Components\Textarea::make('hero_subtitle')
                                    ->label('وصف القسم الرئيسي')
                                    ->rows(3)
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('من نحن')
                            ->schema([
                                Forms\Components\TextInput::make('about_title')
                                    ->label('عنوان قسم من نحن')
                                    ->required(),
                                Forms\Components\Textarea::make('about_body')
                                    ->label('نص من نحن')
                                    ->rows(5)
                                    ->required(),
                                Forms\Components\Textarea::make('vision')
                                    ->label('رؤيتنا')
                                    ->rows(3),
                                Forms\Components\Textarea::make('mission')
                                    ->label('رسالتنا')
                                    ->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('التواصل')
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('رقم الهاتف')
                                    ->tel(),
                                Forms\Components\TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->email(),
                                Forms\Components\TextInput::make('whatsapp')
                                    ->label('واتساب')
                                    ->helperText('رقم دولي بدون رموز، مثال: 2010xxxxxxxx'),
                                Forms\Components\TextInput::make('facebook_url')
                                    ->label('رابط فيسبوك')
                                    ->url()
                                    ->placeholder('https://facebook.com/yourpage'),
                                Forms\Components\TextInput::make('instagram_url')
                                    ->label('رابط إنستجرام')
                                    ->url()
                                    ->placeholder('https://instagram.com/yourpage'),
                                Forms\Components\Textarea::make('address')
                                    ->label('العنوان (عربي)')
                                    ->rows(2),
                                Forms\Components\Textarea::make('address_en')
                                    ->label('العنوان (إنجليزي)')
                                    ->rows(2),
                                Forms\Components\TextInput::make('map_query')
                                    ->label('موقع الخريطة')
                                    ->helperText('نص البحث في خرائط جوجل، مثال: العنوان بالإنجليزية')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('footer_text')
                                    ->label('نص التذييل')
                                    ->rows(2),
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
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('تم حفظ الإعدادات بنجاح')
            ->success()
            ->send();
    }
}
