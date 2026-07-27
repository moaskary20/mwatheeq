<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Goal;
use App\Models\Partner;
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
            'clients' => Client::query()->published()->get(),
            'partners' => Partner::query()->published()->get(),
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
            'map_query' => '41 Tutankhamun Street, Smouha, Al Jawhara Building, Alexandria',
            'whatsapp' => '',
            'whatsapp_display' => '01272269000',
            'facebook_url' => '',
            'instagram_url' => '',
            'footer_text' => '',
            'footer_designed_by' => '',
            'footer_designer_name' => 'Caesar Agency',
            'preloader_welcome' => '',
            'goals_subtitle' => 'نحن ملتزمون بتحقيق أهدافنا من خلال فريق عمل محترف وملتزم.',
            'website_url' => 'mwatheeq.com',
            'intro_eyebrow' => '',
            'intro_title' => '',
            'intro_p1' => '',
            'intro_p2' => '',
            'intro_p3' => '',
            'intro_p4' => '',
            'intro_float_label' => '',
            'intro_float_value' => '',
            'intro_trust_exp' => '',
            'intro_trust_exp_sub' => '',
            'intro_trust_speed' => '',
            'intro_trust_speed_sub' => '',
            'intro_trust_commit' => '',
            'intro_trust_commit_sub' => '',
            'intro_tags' => '',
            'intro_image' => 'image/sections/intro.jpg',
            'services_eyebrow' => '',
            'services_title' => '',
            'services_lead' => '',
            'goals_eyebrow' => '',
            'goals_title' => '',
            'why_eyebrow' => '',
            'why_title' => '',
            'why_lead' => '',
            'clients_eyebrow' => '',
            'clients_title' => '',
            'clients_lead' => '',
            'clients_count_label' => '',
            'clients_sectors' => '',
            'clients_sectors_sub' => '',
            'clients_partnership' => '',
            'clients_partnership_sub' => '',
            'partners_eyebrow' => '',
            'partners_title' => '',
            'partners_lead' => '',
            'partners_seal' => '',
            'partners_label' => '',
            'contact_eyebrow' => '',
            'contact_title' => '',
            'contact_lead' => '',
            'cta_consult' => '',
            'cta_view_services' => '',
            'cta_contact_us' => '',
            'cta_contact_now' => '',
            'cta_request_service' => '',
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
            'mapEmbedUrl' => 'https://www.google.com/maps?q='.rawurlencode($mapQuery).'&hl='.app()->getLocale().'&z=16&output=embed',
            'mapSearchUrl' => 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($mapQuery),
        ];
    }
}
