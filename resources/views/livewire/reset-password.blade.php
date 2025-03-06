<div>
    @if (session('status'))
        <x-alert type="success" :message="session('status')" />
    @endif
    <h4 class="mb-12">Reset Password</h4>
    <p class="mb-16 text-secondary-light text-lg">
        Enter your new password
    </p>
    <form wire:submit.prevent="resetPassword">
        <input type="hidden" wire:model="token">
        <input type="hidden" wire:model="email">
        <div class="mb-20">
            <div class="position-relative">
                <div class="icon-field">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                    </span>
                    <input type="password" name="password" wire:model="password"
                        class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Password">
                </div>
                <span
                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                    data-toggle="#your-password"></span>
            </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="position-relative mb-20">
            <div class="icon-field">
                <span class="icon top-50 translate-middle-y">
                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                </span>
                <input type="password" name="password_confirmation" wire:model="password_confirmation"
                    class="form-control h-56-px bg-neutral-50 radius-12" id="password" placeholder="Confirm Password">
            </div>
            <span
                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                data-toggle="#password"></span>
        </div>
        <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12">Reset
            Password</button>
    </form>
</div>