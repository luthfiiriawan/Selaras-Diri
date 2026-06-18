<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Helpers\Google2FA;
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
            'twoFactorConfirmed' => SiteSetting::query()->where('key', 'two_factor_confirmed')->value('value') === '1',
            'twoFactorSecret' => SiteSetting::query()->where('key', 'two_factor_secret')->value('value'),
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

    public function generate2faSecret(Request $request): RedirectResponse
    {
        $secret = Google2FA::generateSecretKey();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'two_factor_secret'],
            ['value' => $secret, 'group' => 'security']
        );

        SiteSetting::query()->updateOrCreate(
            ['key' => 'two_factor_confirmed'],
            ['value' => '0', 'group' => 'security']
        );

        return back()->with('status', 'Berhasil membuat kunci rahasia 2FA baru. Silakan konfirmasi.');
    }

    public function enable2fa(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $secret = SiteSetting::query()->where('key', 'two_factor_secret')->value('value');

        if (! $secret || ! Google2FA::verifyCode($secret, $request->input('code'))) {
            return back()->withErrors(['two_factor_code' => 'Kode verifikasi OTP tidak cocok. Silakan coba lagi.']);
        }

        SiteSetting::query()->updateOrCreate(
            ['key' => 'two_factor_confirmed'],
            ['value' => '1', 'group' => 'security']
        );

        return back()->with('status', 'Otentikasi Dua Faktor (2FA) berhasil diaktifkan.');
    }

    public function disable2fa(Request $request): RedirectResponse
    {
        SiteSetting::query()->where('key', 'two_factor_confirmed')->delete();
        SiteSetting::query()->where('key', 'two_factor_secret')->delete();

        return back()->with('status', 'Otentikasi Dua Faktor (2FA) telah dinonaktifkan.');
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

            // Prefer Vercel Blob — works on the read-only serverless filesystem
            // and serves images via CDN.
            $blobUrl = $this->uploadToBlob($file);
            if ($blobUrl !== null) {
                return $blobUrl;
            }

            // Local/dev fallback: write to the public dir when it is writable.
            try {
                $dir = public_path('images/uploads');
                if (! is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }

                $filename = time() . '_' . $file->hashName();
                $file->move($dir, $filename);

                return '/images/uploads/' . $filename;
            } catch (\Throwable) {
                // ignore and use fallback below
            }
        }

        if ($request->filled('image_url_fallback')) {
            return $request->input('image_url_fallback');
        }

        return $existing;
    }

    /**
     * Upload a file to Vercel Blob and return its public URL, or null when the
     * Blob token is not configured or the upload fails.
     */
    private function uploadToBlob(UploadedFile $file): ?string
    {
        $token = config('cms.blob_token');

        if (empty($token)) {
            return null;
        }

        $contents = @file_get_contents($file->getRealPath());
        if ($contents === false) {
            return null;
        }

        $pathname = 'psikolog/' . $file->hashName();

        $ch = curl_init('https://blob.vercel-storage.com/' . $pathname);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => 'PUT',
            CURLOPT_POSTFIELDS     => $contents,
            CURLOPT_HTTPHEADER     => [
                'authorization: Bearer ' . $token,
                'x-api-version: 7',
                'x-content-type: ' . ($file->getMimeType() ?: 'application/octet-stream'),
                'x-add-random-suffix: 1',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
        ]);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status === 200 && is_string($response)) {
            $data = json_decode($response, true);

            return $data['url'] ?? null;
        }

        return null;
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
