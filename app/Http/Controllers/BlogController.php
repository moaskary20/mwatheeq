<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('site.blog.index', [
            'settings' => $this->settings(),
            'posts' => BlogPost::query()->published()->paginate(9),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        $post->load(['approvedComments']);

        return view('site.blog.show', [
            'settings' => $this->settings(),
            'post' => $post,
            'comments' => $post->approvedComments,
            'related' => BlogPost::query()
                ->published()
                ->where('id', '!=', $post->id)
                ->limit(3)
                ->get(),
        ]);
    }

    public function comment(Request $request, BlogPost $post): RedirectResponse
    {
        abort_unless($post->is_published, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'يرجى إدخال الاسم.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'body.required' => 'يرجى كتابة الرد.',
        ]);

        BlogComment::query()->create([
            ...$validated,
            'blog_post_id' => $post->id,
            'is_approved' => false,
        ]);

        return back()->with('success', 'تم إرسال ردّك بنجاح، وسيظهر بعد المراجعة.');
    }

    /**
     * @return array<string, string>
     */
    protected function settings(): array
    {
        return Setting::many([
            'site_tagline' => '',
            'hero_subtitle' => '',
            'footer_text' => '',
            'phone' => '',
            'email' => '',
            'whatsapp' => '',
            'facebook_url' => '',
            'instagram_url' => '',
        ]);
    }
}
