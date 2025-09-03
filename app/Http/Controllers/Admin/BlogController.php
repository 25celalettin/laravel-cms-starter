<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    private $statuses = [
        [
            'value' => 'draft',
            'label' => 'Taslak',
        ],
        [
            'value' => 'published',
            'label' => 'Yayınlandı',
        ],
        [
            'value' => 'archived',
            'label' => 'Arşivlendi',
        ],
    ];

    private $statusLabels = [
        'draft' => 'Taslak',
        'published' => 'Yayınlandı',
        'archived' => 'Arşivlendi',
    ];

    public function index()
    {
        $blogs = Blog::query();

        if (request()->filled('search')) {
            $blogs->where('title', 'like', '%' . request('search') . '%');
            $blogs->orWhere('content', 'like', '%' . request('search') . '%');
            $blogs->orWhereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        }

        if (request()->filled('status')) {
            $blogs->where('status', request('status'));
        }

        $blogs->orderBy('created_at', 'desc');

        $blogs = $blogs->paginate(20);

        $statusLabels = $this->statusLabels;
        return view('admin.blogs.index', compact('blogs', 'statusLabels'));
    }

    public function create()
    {
        $statuses = $this->statuses;
        return view('admin.blogs.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'status' => 'required|string|in:draft,published,archived',
            'content' => 'required|string|max:50000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('slug') && $request->slug != null) {
            $validated['slug'] = Str::slug($request->slug);
        }
        else {
            $validated['slug'] = Str::slug($request->title);
        }

        // control slug unique, if not unique, add -1, -2, -3, etc.
        $slug = $validated['slug'];
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $validated['slug'] . '-' . $count;
            $count++;
        }

        $authUser = Auth::user();
        $validated['user_id'] = $authUser->id;

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                
                // Dosya türü kontrolü
                if (!in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                    return back()->with('error', 'Desteklenmeyen dosya formatı. Lütfen JPG, PNG veya GIF formatında bir resim yükleyin.');
                }

                // Dosya boyutu kontrolü (5MB)
                if ($image->getSize() > 5 * 1024 * 1024) {
                    return back()->with('error', 'Dosya boyutu çok büyük. Maksimum 5MB boyutunda bir resim yükleyin.');
                }

                // Benzersiz dosya adı oluştur
                $imageName = uniqid('blog_') . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Yıl ve ay klasörlerini oluştur
                $yearFolder = date('Y');
                $monthFolder = date('m');
                $storagePath = "blogs/{$yearFolder}/{$monthFolder}";
                
                // Klasörlerin varlığını kontrol et ve oluştur
                if (!Storage::disk('public')->exists($storagePath)) {
                    Storage::disk('public')->makeDirectory($storagePath, 0755, true);
                }
                
                // Resmi kaydet
                $image->storeAs($storagePath, $imageName, 'public');
                
                // Validate edilmiş dataya resim adını ekle
                $validated['image'] = 'storage/' . $storagePath . '/' . $imageName;
            }
            catch (\Exception $e) {
                return redirect()->route('admin.blogs.create')->withInput()->with('error', 'Resim yüklenirken bir hata oluştu. Lütfen tekrar deneyin.');
            }
        }

        $blog = Blog::create($validated);

        return redirect()->route('admin.blogs.edit', $blog)->with('success', 'Blog başarıyla oluşturuldu.');
    }

    public function edit(Blog $blog)
    {
        $statuses = $this->statuses;
        return view('admin.blogs.edit', compact('blog', 'statuses'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'status' => 'required|string|in:draft,published,archived',
            'content' => 'required|string|max:50000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('slug') && $request->slug != null) {
            $validated['slug'] = Str::slug($request->slug);
        }
        else {
            $validated['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('image')) {
            $blog->deleteImage();

            try {
                $image = $request->file('image');
                
                // Dosya türü kontrolü
                if (!in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                    return back()->with('error', 'Desteklenmeyen dosya formatı. Lütfen JPG, PNG veya GIF formatında bir resim yükleyin.');
                }

                // Dosya boyutu kontrolü (5MB)
                if ($image->getSize() > 5 * 1024 * 1024) {
                    return back()->with('error', 'Dosya boyutu çok büyük. Maksimum 5MB boyutunda bir resim yükleyin.');
                }

                // Benzersiz dosya adı oluştur
                $imageName = uniqid('blog_') . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Yıl ve ay klasörlerini oluştur
                $yearFolder = date('Y');
                $monthFolder = date('m');
                $storagePath = "blogs/{$yearFolder}/{$monthFolder}";
                
                // Klasörlerin varlığını kontrol et ve oluştur
                if (!Storage::disk('public')->exists($storagePath)) {
                    Storage::disk('public')->makeDirectory($storagePath, 0755, true);
                }
                
                // Resmi kaydet
                $image->storeAs($storagePath, $imageName, 'public');
                
                // Validate edilmiş dataya resim adını ekle
                $validated['image'] = 'storage/' . $storagePath . '/' . $imageName;
            }
            catch (\Exception $e) {
                return redirect()->route('admin.blogs.edit', $blog)->withInput()->with('error', 'Resim yüklenirken bir hata oluştu. Lütfen tekrar deneyin.');
            }
        }
        
        $blog->update($validated);

        return redirect()->route('admin.blogs.edit', $blog)->with('success', 'Blog başarıyla güncellendi.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog başarıyla silindi.',
        ], 200);
    }
}
