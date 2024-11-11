<div class="container pt-4">
    <div class="bg-white overflow-hidden shadow-sm rounded-4 card">
        <div class="card-body p-4 p-lg-5">
            <section>
                <header>
                    <h2 class="fs-4 fw-medium mb-4">{{ __('Update Password') }}</h2>
                    <p class="text-muted mb-4">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="mt-6">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="update_password_current_password" class="form-label"><strong>{{ __('Current Password') }}:</strong></label>
                        <input type="password" 
                            name="current_password" 
                            class="form-control @error('current_password') is-invalid @enderror" 
                            id="update_password_current_password"
                            required>
                        @error('current_password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="update_password_password" class="form-label"><strong>{{ __('New Password') }}:</strong></label>
                        <input type="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="update_password_password"
                            required>
                        @error('password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="update_password_password_confirmation" class="form-label"><strong>{{ __('Confirm Password') }}:</strong></label>
                        <input type="password" 
                            name="password_confirmation" 
                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                            id="update_password_password_confirmation"
                            required>
                        @error('password_confirmation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> {{ __('Save') }}
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }"
                               x-show="show"
                               x-transition
                               x-init="setTimeout(() => show = false, 2000)"
                               class="text-success">{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
