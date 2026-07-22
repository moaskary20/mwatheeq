<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Goal;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\WhyPoint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $settings = $this->settings();
        $map = $this->mapData($settings);

        return view('site.home', array_merge($map, [
            'settings' => $settings,
            'services' => Service::query()->published()->get(),
            'slides' => Slide::query()->published()->get(),
            'goals' => Goal::query()->published()->get(),
            'whyPoints' => WhyPoint::query()->published()->get(),
            'clients' => $this->clients(),
            'partners' => $this->partners(),
        ]));
    }

    public function services(): View
    {
        $settings = $this->settings();

        return view('site.services', [
            'settings' => $settings,
            'services' => Service::query()->published()->get(),
        ]);
    }

    public function about(): View
    {
        $settings = $this->settings();

        return view('site.about', [
            'settings' => $settings,
            'goals' => Goal::query()->published()->get(),
            'whyPoints' => WhyPoint::query()->published()->get(),
        ]);
    }

    public function contactPage(): View
    {
        $settings = $this->settings();
        $map = $this->mapData($settings);

        return view('site.contact', array_merge($map, [
            'settings' => $settings,
        ]));
    }

    public function contact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'يرجى إدخال الاسم.',
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'message.required' => 'يرجى كتابة رسالتك.',
        ]);

        ContactMessage::query()->create($validated);

        return back()->with('success', 'تم إرسال رسالتك بنجاح، وسنتواصل معك قريباً.');
    }

    /**
     * @return array<string, string>
     */
    protected function settings(): array
    {
        return Setting::many([
            'site_tagline' => '',
            'hero_title' => '',
            'hero_subtitle' => '',
            'about_title' => '',
            'about_body' => '',
            'vision' => '',
            'mission' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
            'address_en' => '',
            'map_query' => '9 Dr. Burji Street, next to Al Ahly Specialized Hospital, Kafr Abdo, Alexandria',
            'whatsapp' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'footer_text' => '',
            'goals_subtitle' => 'نحن ملتزمون بتحقيق أهدافنا من خلال فريق عمل محترف وملتزم.',
            'website_url' => 'mwatheeq.com',
        ]);
    }

    /**
     * @param  array<string, string>  $settings
     * @return array{mapEmbedUrl: string, mapSearchUrl: string, mapQuery: string}
     */
    protected function mapData(array $settings): array
    {
        $mapQuery = $settings['map_query'] ?: $settings['address_en'] ?: $settings['address'];

        return [
            'mapQuery' => $mapQuery,
            'mapEmbedUrl' => 'https://www.google.com/maps?q='.rawurlencode($mapQuery).'&hl=ar&z=16&output=embed',
            'mapSearchUrl' => 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($mapQuery),
        ];
    }

    /**
     * @return list<array{name: string, logo: string}>
     */
    protected function clients(): array
    {
        return [
            ['name' => 'شركة الصفاء للاستيراد والتصدير (للمولدات)', 'logo' => 'image/clients/al-safa.svg'],
            ['name' => 'شركة الوادي لتصدير الحاصلات الزراعية', 'logo' => 'image/clients/al-wadi.svg'],
            ['name' => 'شركة الحياة للإنشاء والتعمير', 'logo' => 'image/clients/al-hayat.svg'],
            ['name' => 'شركة البركة لقطاع غيار سيارات النقل الثقيل', 'logo' => 'image/clients/al-baraka-parts.svg'],
            ['name' => 'الجمعية التعاونية للبناء والإسكان للعاملين بشركة النصر للأصواف والمنسوجات الممتازة (ستيا)', 'logo' => 'image/clients/setia-coop.svg'],
            ['name' => 'بنك البركة مصر', 'logo' => 'image/clients/al-baraka-bank.svg'],
            ['name' => 'شركة حلوان للحديد والصلب', 'logo' => 'image/clients/helwan-steel.svg'],
        ];
    }

    /**
     * @return list<array{name: string, icon: string}>
     */
    protected function partners(): array
    {
        return [
            ['name' => 'مأموريات الشهر العقاري', 'icon' => 'registry'],
            ['name' => 'هيئة المساحة المصرية', 'icon' => 'survey'],
            ['name' => 'هيئة الطيران المدني', 'icon' => 'aviation'],
            ['name' => 'هيئة الآثار', 'icon' => 'antiquities'],
            ['name' => 'هيئة المياه وهيئة الصرف الصحي', 'icon' => 'water'],
            ['name' => 'هيئة الاستثمار', 'icon' => 'investment'],
            ['name' => 'هيئة الاتصالات', 'icon' => 'telecom'],
            ['name' => 'هيئة المجتمعات العمرانية', 'icon' => 'urban'],
            ['name' => 'جهاز مدينة برج العرب', 'icon' => 'city'],
            ['name' => 'جهاز مدينة ٦ أكتوبر', 'icon' => 'city-oct'],
            ['name' => 'وجميع الهيئات والمؤسسات الحكومية الأخرى', 'icon' => 'government'],
        ];
    }
}
