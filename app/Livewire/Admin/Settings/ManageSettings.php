<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\AppSetting;
use App\Services\FonnteService;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class ManageSettings extends Component
{
    use WithFileUploads;

    public $nama_instansi;
    public $singkatan;
    public $deskripsi;
    public $alamat;
    public $kontak;
    public $email;
    public $warna_tema;

    // File upload properties
    public $logo;
    public $existingLogo;

    // Fonnte / WhatsApp
    public bool $whatsapp_notif_enabled = false;
    public string $fonnte_token = '';
    public string $test_wa_target = '';

    public function mount()
    {
        $settings = AppSetting::getSettings();
        $this->nama_instansi = $settings->nama_instansi;
        $this->singkatan = $settings->singkatan;
        $this->deskripsi = $settings->deskripsi;
        $this->alamat = $settings->alamat;
        $this->kontak = $settings->kontak;
        $this->email = $settings->email;
        $this->warna_tema = $settings->warna_tema;
        $this->existingLogo = $settings->logo_path;
        $this->whatsapp_notif_enabled = (bool) $settings->whatsapp_notif_enabled;
        $this->fonnte_token = $settings->fonnte_token ?? '';
    }

    public function save()
    {
        $rules = [
            'nama_instansi'          => 'required|string|max:255',
            'singkatan'              => 'nullable|string|max:50',
            'deskripsi'              => 'nullable|string',
            'alamat'                 => 'nullable|string',
            'kontak'                 => 'nullable|string|max:255',
            'email'                  => 'nullable|email|max:255',
            'warna_tema'             => 'required|string|max:20',
            'fonnte_token'           => 'nullable|string|max:255',
            'whatsapp_notif_enabled' => 'boolean',
        ];

        if ($this->logo) {
            $rules['logo'] = 'nullable|image|max:2048';
        }

        $this->validate($rules);

        $settings = AppSetting::first() ?? new AppSetting();

        $settings->fill([
            'nama_instansi'          => $this->nama_instansi,
            'singkatan'              => $this->singkatan,
            'deskripsi'              => $this->deskripsi,
            'alamat'                 => $this->alamat,
            'kontak'                 => $this->kontak,
            'email'                  => $this->email,
            'warna_tema'             => $this->warna_tema,
            'whatsapp_notif_enabled' => $this->whatsapp_notif_enabled,
            'fonnte_token'           => $this->fonnte_token ?: null,
        ]);

        if ($this->logo) {
            if ($settings->logo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($settings->logo_path);
            }
            $logoPath = $this->logo->store('logos', 'public');
            $settings->logo_path = $logoPath;
            $this->existingLogo = $logoPath;
            $this->logo = null;
        }

        $settings->save();

        session()->flash('message', 'Pengaturan aplikasi berhasil disimpan.');
        return $this->redirect(route('admin.settings'), navigate: true);
    }

    public function deleteLogo()
    {
        $settings = AppSetting::first();
        if ($settings && $settings->logo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($settings->logo_path);
            $settings->logo_path = null;
            $settings->save();
            $this->existingLogo = null;
            $this->logo = null;

            session()->flash('message', 'Logo berhasil dihapus. Kembali menggunakan logo bawaan.');
            return $this->redirect(route('admin.settings'), navigate: true);
        }
    }

    public function testWa()
    {
        $this->validate(['test_wa_target' => 'required|string|min:9']);

        // Simpan token & aktifkan sementara agar FonnteService bisa kirim
        $settings = AppSetting::first();
        if ($settings && !empty($this->fonnte_token)) {
            $settings->fonnte_token = $this->fonnte_token;
            $settings->whatsapp_notif_enabled = true;
            $settings->save();
        }

        // Re-instantiate agar pakai token terbaru dari DB
        $fonnte = new FonnteService();
        $result = $fonnte->send(
            $this->test_wa_target,
            "🧪 *Test Koneksi STARPAS*\n\nHalo! Ini adalah pesan uji coba dari sistem STARPAS Kanwil Ditjenpas Banten.\n\nJika Anda menerima pesan ini, berarti integrasi WhatsApp berhasil! ✅"
        );

        if ($result) {
            session()->flash('message', '✅ Pesan WhatsApp uji coba berhasil dikirim ke ' . $this->test_wa_target);
        } else {
            session()->flash('error', '❌ Gagal mengirim WA. Pastikan token Fonnte dan nomor HP benar.');
        }

        $this->test_wa_target = '';
        return $this->redirect(route('admin.settings'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.settings.manage-settings');
    }
}
