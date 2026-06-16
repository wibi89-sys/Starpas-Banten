<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\AppSetting;
use App\Models\MasterUpt;
use App\Models\MasterBidang;
use Spatie\Permission\Models\Role;
use App\Services\FonnteService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class ManageSettings extends Component
{
    use WithFileUploads;

    #[Url]
    public string $tab = 'general';

    // General app setting properties
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

    // UPT state
    public bool $showUptModal = false;
    public bool $showDeleteUptModal = false;
    public ?int $editingUptId = null;
    public string $upt_nama = '';
    public string $upt_jenis = '';
    public string $upt_alamat = '';
    public bool $upt_is_active = true;
    public ?int $deletingUptId = null;
    public string $deletingUptName = '';
    public string $searchUpt = '';

    // Role state
    public bool $showRoleModal = false;
    public bool $showDeleteRoleModal = false;
    public ?int $editingRoleId = null;
    public string $role_name = '';
    public ?int $deletingRoleId = null;
    public string $deletingRoleName = '';
    public string $searchRole = '';

    // Bidang state
    public bool $showBidangModal = false;
    public bool $showDeleteBidangModal = false;
    public ?int $editingBidangId = null;
    public string $bidang_nama = '';
    public string $bidang_deskripsi = '';
    public bool $bidang_is_active = true;
    public ?int $deletingBidangId = null;
    public string $deletingBidangName = '';
    public string $searchBidang = '';

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

    public function setTab($tabName)
    {
        $this->tab = $tabName;
        $this->resetValidation();
        // Reset modals
        $this->showUptModal = false;
        $this->showDeleteUptModal = false;
        $this->showRoleModal = false;
        $this->showDeleteRoleModal = false;
        $this->showBidangModal = false;
        $this->showDeleteBidangModal = false;
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
        return $this->redirect(route('admin.settings', ['tab' => $this->tab]), navigate: true);
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
            return $this->redirect(route('admin.settings', ['tab' => $this->tab]), navigate: true);
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
        return $this->redirect(route('admin.settings', ['tab' => $this->tab]), navigate: true);
    }

    // ==========================================
    // UPT CRUD METHODS
    // ==========================================
    public function openCreateUpt()
    {
        $this->resetUptForm();
        $this->editingUptId = null;
        $this->showUptModal = true;
    }

    public function openEditUpt($id)
    {
        $this->resetUptForm();
        $upt = MasterUpt::findOrFail($id);
        $this->editingUptId = $id;
        $this->upt_nama = $upt->nama_upt;
        $this->upt_jenis = $upt->jenis_upt;
        $this->upt_alamat = $upt->alamat ?? '';
        $this->upt_is_active = (bool) $upt->is_active;
        $this->showUptModal = true;
    }

    public function saveUpt()
    {
        $this->validate([
            'upt_nama' => 'required|string|max:255',
            'upt_jenis' => 'required|string|max:100',
            'upt_alamat' => 'nullable|string',
            'upt_is_active' => 'boolean',
        ], [
            'upt_nama.required' => 'Nama UPT wajib diisi.',
            'upt_jenis.required' => 'Jenis UPT wajib diisi.',
        ]);

        if ($this->editingUptId) {
            $upt = MasterUpt::findOrFail($this->editingUptId);
            $upt->update([
                'nama_upt' => $this->upt_nama,
                'jenis_upt' => $this->upt_jenis,
                'alamat' => $this->upt_alamat,
                'is_active' => $this->upt_is_active,
            ]);
            session()->flash('message_upt', 'UPT berhasil diperbarui.');
        } else {
            MasterUpt::create([
                'nama_upt' => $this->upt_nama,
                'jenis_upt' => $this->upt_jenis,
                'alamat' => $this->upt_alamat,
                'is_active' => $this->upt_is_active,
            ]);
            session()->flash('message_upt', 'UPT baru berhasil ditambahkan.');
        }

        $this->showUptModal = false;
        $this->resetUptForm();
    }

    public function toggleUptActive($id)
    {
        $upt = MasterUpt::findOrFail($id);
        $upt->is_active = !$upt->is_active;
        $upt->save();
        session()->flash('message_upt', 'Status UPT "' . $upt->nama_upt . '" berhasil diubah.');
    }

    public function confirmDeleteUpt($id)
    {
        $upt = MasterUpt::findOrFail($id);
        $this->deletingUptId = $id;
        $this->deletingUptName = $upt->nama_upt;
        $this->showDeleteUptModal = true;
    }

    public function deleteUpt()
    {
        if ($this->deletingUptId) {
            $upt = MasterUpt::findOrFail($this->deletingUptId);
            $upt->delete();
            session()->flash('message_upt', 'UPT "' . $this->deletingUptName . '" berhasil dihapus.');
        }
        $this->showDeleteUptModal = false;
        $this->deletingUptId = null;
        $this->deletingUptName = '';
    }

    private function resetUptForm()
    {
        $this->editingUptId = null;
        $this->upt_nama = '';
        $this->upt_jenis = '';
        $this->upt_alamat = '';
        $this->upt_is_active = true;
        $this->resetValidation();
    }

    // ==========================================
    // ROLE (USER LEVEL) CRUD METHODS
    // ==========================================
    public function openCreateRole()
    {
        $this->resetRoleForm();
        $this->editingRoleId = null;
        $this->showRoleModal = true;
    }

    public function openEditRole($id)
    {
        $this->resetRoleForm();
        $role = Role::findOrFail($id);
        $this->editingRoleId = $id;
        $this->role_name = $role->name;
        $this->showRoleModal = true;
    }

    public function saveRole()
    {
        $this->validate([
            'role_name' => 'required|string|max:100|unique:roles,name,' . ($this->editingRoleId ?? 'NULL'),
        ], [
            'role_name.required' => 'Nama level (role) wajib diisi.',
            'role_name.unique' => 'Nama level (role) sudah digunakan.',
        ]);

        if ($this->editingRoleId) {
            $role = Role::findOrFail($this->editingRoleId);
            $role->name = $this->role_name;
            $role->save();
            session()->flash('message_role', 'Level user berhasil diperbarui.');
        } else {
            Role::create(['name' => $this->role_name]);
            session()->flash('message_role', 'Level user baru berhasil ditambahkan.');
        }

        $this->showRoleModal = false;
        $this->resetRoleForm();
    }

    public function confirmDeleteRole($id)
    {
        $role = Role::findOrFail($id);
        $this->deletingRoleId = $id;
        $this->deletingRoleName = $role->name;

        // Check if there are users with this role
        $userCount = DB::table('model_has_roles')->where('role_id', $id)->count();
        if ($userCount > 0) {
            session()->flash('error_role', 'Tidak dapat menghapus. Level "' . $role->name . '" masih digunakan oleh ' . $userCount . ' pengguna.');
            $this->deletingRoleId = null;
            $this->deletingRoleName = '';
            return;
        }

        $this->showDeleteRoleModal = true;
    }

    public function deleteRole()
    {
        if ($this->deletingRoleId) {
            $role = Role::findOrFail($this->deletingRoleId);
            $role->delete();
            session()->flash('message_role', 'Level "' . $this->deletingRoleName . '" berhasil dihapus.');
        }
        $this->showDeleteRoleModal = false;
        $this->deletingRoleId = null;
        $this->deletingRoleName = '';
    }

    private function resetRoleForm()
    {
        $this->editingRoleId = null;
        $this->role_name = '';
        $this->resetValidation();
    }

    // ==========================================
    // BIDANG CRUD METHODS
    // ==========================================
    public function openCreateBidang()
    {
        $this->resetBidangForm();
        $this->editingBidangId = null;
        $this->showBidangModal = true;
    }

    public function openEditBidang($id)
    {
        $this->resetBidangForm();
        $bidang = MasterBidang::findOrFail($id);
        $this->editingBidangId = $id;
        $this->bidang_nama = $bidang->nama_bidang;
        $this->bidang_deskripsi = $bidang->deskripsi ?? '';
        $this->bidang_is_active = (bool) $bidang->is_active;
        $this->showBidangModal = true;
    }

    public function saveBidang()
    {
        $this->validate([
            'bidang_nama' => 'required|string|max:255|unique:master_bidangs,nama_bidang,' . ($this->editingBidangId ?? 'NULL'),
            'bidang_deskripsi' => 'nullable|string',
            'bidang_is_active' => 'boolean',
        ], [
            'bidang_nama.required' => 'Nama tim wajib diisi.',
            'bidang_nama.unique' => 'Nama tim sudah digunakan.',
        ]);

        if ($this->editingBidangId) {
            $bidang = MasterBidang::findOrFail($this->editingBidangId);
            $bidang->update([
                'nama_bidang' => $this->bidang_nama,
                'deskripsi' => $this->bidang_deskripsi,
                'is_active' => $this->bidang_is_active,
            ]);
            session()->flash('message_bidang', 'Tim berhasil diperbarui.');
        } else {
            MasterBidang::create([
                'nama_bidang' => $this->bidang_nama,
                'deskripsi' => $this->bidang_deskripsi,
                'is_active' => $this->bidang_is_active,
            ]);
            session()->flash('message_bidang', 'Tim baru berhasil ditambahkan.');
        }

        $this->showBidangModal = false;
        $this->resetBidangForm();
    }

    public function toggleBidangActive($id)
    {
        $bidang = MasterBidang::findOrFail($id);
        $bidang->is_active = !$bidang->is_active;
        $bidang->save();
        session()->flash('message_bidang', 'Status Tim "' . $bidang->nama_bidang . '" berhasil diubah.');
    }

    public function confirmDeleteBidang($id)
    {
        $bidang = MasterBidang::findOrFail($id);
        $this->deletingBidangId = $id;
        $this->deletingBidangName = $bidang->nama_bidang;
        $this->showDeleteBidangModal = true;
    }

    public function deleteBidang()
    {
        if ($this->deletingBidangId) {
            $bidang = MasterBidang::findOrFail($this->deletingBidangId);
            $bidang->delete();
            session()->flash('message_bidang', 'Tim "' . $this->deletingBidangName . '" berhasil dihapus.');
        }
        $this->showDeleteBidangModal = false;
        $this->deletingBidangId = null;
        $this->deletingBidangName = '';
    }

    private function resetBidangForm()
    {
        $this->editingBidangId = null;
        $this->bidang_nama = '';
        $this->bidang_deskripsi = '';
        $this->bidang_is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        $upts = MasterUpt::when($this->searchUpt, function($q) {
                return $q->where('nama_upt', 'like', '%' . $this->searchUpt . '%')
                         ->orWhere('jenis_upt', 'like', '%' . $this->searchUpt . '%')
                         ->orWhere('alamat', 'like', '%' . $this->searchUpt . '%');
            })
            ->orderBy('nama_upt')
            ->get();

        $roles = Role::when($this->searchRole, function($q) {
                return $q->where('name', 'like', '%' . $this->searchRole . '%');
            })
            ->orderBy('name')
            ->get()
            ->map(function($role) {
                $role->user_count = DB::table('model_has_roles')->where('role_id', $role->id)->count();
                return $role;
            });

        $bidangs = MasterBidang::when($this->searchBidang, function($q) {
                return $q->where('nama_bidang', 'like', '%' . $this->searchBidang . '%')
                         ->orWhere('deskripsi', 'like', '%' . $this->searchBidang . '%');
            })
            ->orderBy('nama_bidang')
            ->get();

        return view('livewire.admin.settings.manage-settings', compact('upts', 'roles', 'bidangs'));
    }
}
