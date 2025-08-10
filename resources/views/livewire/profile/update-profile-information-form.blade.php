<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Provinsi;
use App\Models\Kota;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';

    #[Validate('nullable|image|max:2048')]
    public $fotoProfil;
    public $currentProfil = null;

    public $headline;
    public $keterangan;
    public $provinsis;
    public $kotas;
    public $provinsiId;
    public $kotaId;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->currentProfil = $user->foto_profil;
        $this->headline = $user->headline;
        $this->keterangan = $user->keterangan;
        $this->provinsiId = $user->provinsi_id;
        $this->kotaId = $user->kota_id;

        $this->provinsis = Provinsi::get();
        $this->kotas = Kota::get();
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'fotoProfil' => ['nullable', 'image', 'max:2048'],
            'headline' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'provinsiId' => ['nullable', 'exists:provinsi,id'],
            'kotaId' => ['nullable', 'exists:kota,id'],
        ]);

        if ($this->fotoProfil) {
            // Delete old avatar if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Store new avatar with a unique name
            $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $this->fotoProfil->getClientOriginalExtension();
            $path = $this->fotoProfil->storeAs('profil', $fileName, 'public');
            $user->foto_profil = $path;

            $this->fotoProfil = null;
        }

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'headline' => $this->headline,
            'keterangan' => $this->keterangan,
            'provinsi_id' => $this->provinsiId,
            'kota_id' => $this->kotaId
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

    $user->save();

        $this->currentProfil = $user->foto_profil;

        $this->dispatch('profile-updated', name: $user->name);

        Session::flash('status', 'profile-updated');
    }

    public function removeAvatar(): void
    {
        $user = Auth::user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->foto_profil = null;
        $user->save();

        $this->currentProfil = null;

        Session::flash('status', 'avatar-removed');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('beranda', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil kamu.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <!-- Foto Profil Section -->
        <div class="space-y-4">
            <x-input-label for="profil" :value="__('Foto Profil')" />
        
            <!-- Current Avatar Display -->
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    @if ($currentProfil)
                        <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-300"
                            src="{{ Storage::url($currentProfil) }}" alt="Current avatar">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                            <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-300"
                                src="{{ asset('images/default-avatar.png') }}" alt="Current avatar">
                        </div>
                    @endif
                </div>
        
                <div class="flex-1 flex items-center gap-4">
                    <!-- Preview for new upload -->
                    @if ($fotoProfil)
                        <div class="mt-2">
                            <img src="{{ $fotoProfil->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-full border-2 border-green-300"
                                alt="Avatar preview">
                        </div>
                    @endif

                    <div>
                        <!-- File Input -->
                        <input type="file" id="avatar" wire:model="fotoProfil" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        
                        <!-- Remove Avatar Button -->
                        @if ($currentProfil && !$fotoProfil)
                            <button type="button" wire:click="removeAvatar" wire:confirm="Anda yakin ingin menghapus foto profil?"
                                class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Hapus Foto Profil
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        
            <div class="text-sm text-gray-500">
                <p>Format diterima: JPG, PNG. Ukuran maksimum: 2MB.</p>
            </div>
        
            <x-input-error class="mt-2" :messages="$errors->get('fotoProfil')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="headline" :value="__('Headline')" />
            <x-text-input wire:model="headline" id="headline" name="headline" type="text" class="mt-1 block w-full" autofocus autocomplete="headline" />
            <x-input-error class="mt-2" :messages="$errors->get('headline')" />
        </div>

        <div>
            <x-input-label for="keterangan" :value="__('Keterangan')" />
            <textarea name="keterangan" id="keterangan" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model="keterangan" autofocus autocomplete="keterangan"></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
        </div>

        <div>
            <x-input-label for="provinsiId" :value="__('Provinsi')" />
            <select name="provinsiId" id="provinsiId" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" wire:model="provinsiId">
                <option value="">Pilih Provinsi...</option>
                @foreach ($provinsis as $provinsi)
                    <option value="{{ $provinsi->id }}">{{ $provinsi->nama_provinsi }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('provinsiId')" />
        </div>

        <div>
            <x-input-label for="kotaId" :value="__('Kota')" />
            <select name="kotaId" id="kotaId"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                wire:model="kotaId">
                <option value="">Pilih Kota...</option>
                @foreach ($kotas as $kota)
                    <option value="{{ $kota->id }}">{{ $kota->nama_kota }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('kotaId')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>
