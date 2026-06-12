<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.app')]
class ManageUsers extends Component
{
    use WithPagination;

    // State modal
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditing = false;

    // Form fields
    public ?int $editingUserId = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $selectedRole = '';

    // Delete
    public ?int $deletingUserId = null;
    public string $deletingUserName = '';

    // Search
    public string $search = '';

    protected function rules(): array
    {
        $passwordRule = $this->isEditing
            ? ['nullable', 'confirmed', Password::min(8)]
            : ['required', 'confirmed', Password::min(8)];

        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . ($this->editingUserId ?? 'NULL'),
            'password'      => $passwordRule,
            'selectedRole'  => 'required|string|exists:roles,name',
        ];
    }

    protected array $messages = [
        'name.required'         => 'Nama wajib diisi.',
        'email.required'        => 'Email wajib diisi.',
        'email.unique'          => 'Email sudah digunakan oleh akun lain.',
        'password.required'     => 'Password wajib diisi.',
        'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        'selectedRole.required' => 'Pilih role untuk pengguna ini.',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEdit(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->resetForm();
        $this->isEditing = true;
        $this->editingUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRole = $user->getRoleNames()->first() ?? '';
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->isEditing) {
            $user = User::findOrFail($this->editingUserId);
            $user->name = $this->name;
            $user->email = $this->email;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->save();
            $user->syncRoles([$this->selectedRole]);
            session()->flash('success', 'Data pengguna berhasil diperbarui.');
        } else {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $user->assignRole($this->selectedRole);
            session()->flash('success', 'Pengguna baru berhasil dibuat.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $userId): void
    {
        // Tidak boleh hapus diri sendiri
        if ($userId === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }
        $user = User::findOrFail($userId);
        $this->deletingUserId = $userId;
        $this->deletingUserName = $user->name;
        $this->showDeleteModal = true;
    }

    public function deleteUser(): void
    {
        if ($this->deletingUserId && $this->deletingUserId !== auth()->id()) {
            $user = User::findOrFail($this->deletingUserId);
            $user->delete();
            session()->flash('success', 'Pengguna "' . $this->deletingUserName . '" berhasil dihapus.');
        }
        $this->showDeleteModal = false;
        $this->deletingUserId = null;
        $this->deletingUserName = '';
    }

    private function resetForm(): void
    {
        $this->editingUserId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selectedRole = '';
        $this->resetValidation();
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.admin.users.manage-users', compact('users', 'roles'));
    }
}
