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

        $user = $request->user();

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ], [
            'body.required' => 'يرجى كتابة الرد.',
        ]);

        BlogComment::query()->create([
            'blog_post_id' => $post->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'body' => $validated['body'],
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
