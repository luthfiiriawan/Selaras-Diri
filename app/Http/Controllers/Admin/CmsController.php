<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\CounselingPackage;
use App\Models\Event;
use App\Models\Psychologist;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class CmsController extends Controller
{
    public function index(): View
    {
        return view('admin.cms', [
            'settings' => array_merge(
                HomeController::defaultSettings(),
                SiteSetting::query()->pluck('value', 'key')->all()
            ),
            'settingFields' => $this->settingFields(),
            'psychologists' => Psychologist::query()->orderBy('sort_order')->orderBy('name')->get(),
            'packages' => CounselingPackage::query()->orderBy('sort_order')->orderBy('title')->get(),
            'events' => Event::query()->orderBy('type')->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $keys = array_keys($this->settingFields());
        $data = $request->validate(array_fill_keys($keys, ['nullable', 'string']));

        foreach ($keys as $key) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value' => $data[$key] ?? '',
                    'group' => str_contains($key, 'whatsapp') ? 'contact' : 'content',
                ]
            );
        }

        return back()->with('status', 'Konten utama berhasil diperbarui.');
    }

    public function storePsychologist(Request $request): RedirectResponse
    {
        $data = $this->validatePsychologist($request);
        $data['image_url'] = $this->resolveImage($request, 'image', null);
        Psychologist::query()->create($data);

        return back()->with('status', 'Data psikolog berhasil ditambahkan.');
    }

    public function updatePsychologist(Request $request, Psychologist $psychologist): RedirectResponse
    {
        $data = $this->validatePsychologist($request);
        $data['image_url'] = $this->resolveImage($request, 'image', $psychologist->image_url);
        $psychologist->update($data);

        return back()->with('status', 'Data psikolog berhasil diperbarui.');
    }

    public function destroyPsychologist(Psychologist $psychologist): RedirectResponse
    {
        $psychologist->delete();

        return back()->with('status', 'Data psikolog berhasil dihapus.');
    }

    public function storePackage(Request $request): RedirectResponse
    {
        CounselingPackage::query()->create($this->validatePackage($request));

        return back()->with('status', 'Pricelist berhasil ditambahkan.');
    }

    public function updatePackage(Request $request, CounselingPackage $package): RedirectResponse
    {
        $package->update($this->validatePackage($request));

        return back()->with('status', 'Pricelist berhasil diperbarui.');
    }

    public function destroyPackage(CounselingPackage $package): RedirectResponse
    {
        $package->delete();

        return back()->with('status', 'Pricelist berhasil dihapus.');
    }

    public function storeEvent(Request $request): RedirectResponse
    {
        $data = $this->validateEvent($request);
        $data['image_url'] = $this->resolveImage($request, 'image', null);
        Event::query()->create($data);

        return back()->with('status', 'Event berhasil ditambahkan.');
    }

    public function updateEvent(Request $request, Event $event): RedirectResponse
    {
        $data = $this->validateEvent($request);
        $data['image_url'] = $this->resolveImage($request, 'image', $event->image_url);
        $event->update($data);

        return back()->with('status', 'Event berhasil diperbarui.');
    }

    public function destroyEvent(Event $event): RedirectResponse
    {
        $event->delete();

        return back()->with('status', 'Event berhasil dihapus.');
    }

    /**
     * Handle image upload or keep existing URL.
     * Priority: uploaded file > fallback_url field > existing value.
     */
    private function resolveImage(Request $request, string $fileField, ?string $existing): ?string
    {
        if ($request->hasFile($fileField) && $request->file($fileField) instanceof UploadedFile) {
            $file = $request->file($fileField);
            $dir = public_path('images/uploads');

            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $filename = time() . '_' . $file->hashName();
            $file->move($dir, $filename);

            return '/images/uploads/' . $filename;
        }

        if ($request->filled('image_url_fallback')) {
            return $request->input('image_url_fallback');
        }

        return $existing;
    }

    private function validatePsychologist(Request $request): array
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'role'           => ['nullable', 'string', 'max:255'],
            'focus'          => ['required', 'string'],
            'specialization' => ['nullable', 'string'],
            'expertise'      => ['nullable', 'string'],
            'schedule'       => ['nullable', 'string', 'max:255'],
            'price'          => ['nullable', 'string'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_url_fallback' => ['nullable', 'string', 'max:500'],
            'sort_order'     => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function validatePackage(Request $request): array
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration'    => ['nullable', 'string', 'max:255'],
            'price'       => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function validateEvent(Request $request): array
    {
        $data = $request->validate([
            'type'            => ['required', 'in:support_group,monthly'],
            'title'           => ['required', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'schedule'        => ['nullable', 'string', 'max:255'],
            'image'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_url_fallback' => ['nullable', 'string', 'max:500'],
            'booking_message' => ['nullable', 'string'],
            'sort_order'      => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function settingFields(): array
    {
        return [
            'site_name'               => ['label' => 'Nama brand', 'type' => 'text'],
            'whatsapp_number'         => ['label' => 'Nomor WhatsApp', 'type' => 'text'],
            'contact_phone'           => ['label' => 'Telepon company profile', 'type' => 'text'],
            'instagram'               => ['label' => 'Instagram', 'type' => 'text'],
            'email'                   => ['label' => 'Email', 'type' => 'text'],
            'location'                => ['label' => 'Lokasi', 'type' => 'text'],
            'hero_eyebrow'            => ['label' => 'Hero eyebrow', 'type' => 'text'],
            'hero_title'              => ['label' => 'Hero headline', 'type' => 'textarea'],
            'hero_subtitle'           => ['label' => 'Hero subtitle', 'type' => 'textarea'],
            'about_title'             => ['label' => 'Judul tentang', 'type' => 'text'],
            'about_heading'           => ['label' => 'Heading tentang', 'type' => 'textarea'],
            'about_body'              => ['label' => 'Isi tentang', 'type' => 'textarea'],
            'vision_title'            => ['label' => 'Judul visi', 'type' => 'text'],
            'vision_body'             => ['label' => 'Isi visi', 'type' => 'textarea'],
            'mission_title'           => ['label' => 'Judul misi', 'type' => 'text'],
            'mission_body'            => ['label' => 'Isi misi', 'type' => 'textarea'],
            'booking_title'           => ['label' => 'Judul booking', 'type' => 'textarea'],
            'booking_body'            => ['label' => 'Isi booking', 'type' => 'textarea'],
            'booking_whatsapp_message'=> ['label' => 'Pesan WA booking', 'type' => 'textarea'],
            'event_whatsapp_message'  => ['label' => 'Pesan WA event', 'type' => 'textarea'],
            'footer_tagline'          => ['label' => 'Tagline footer', 'type' => 'text'],
        ];
    }
}
