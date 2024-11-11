<div class="container pt-4">
    <div class="bg-white overflow-hidden shadow-sm rounded-4 card">
        <div class="card-body p-4 p-lg-5">
            <section class="space-y-6">
                <header>
                    <h2 class="fs-4 fw-medium text-danger mb-4">{{ __('Delete Account') }}</h2>
                    <p class="text-muted mb-4">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
                </header>

                <button 
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="btn btn-danger"
                >{{ __('Delete Account') }}</button>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')

                        <h2 class="fs-4 fw-medium text-danger mb-4">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h2>

                        <p class="text-muted mb-4">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>{{ __('Password') }}:</strong></label>
                            <input type="password"
                                name="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                id="password"
                                placeholder="{{ __('Password') }}"
                                required>
                            @error('password', 'userDeletion')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-outline-secondary me-2" x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> {{ __('Delete Account') }}
                            </button>
                        </div>
                    </form>
                </x-modal>
            </section>
        </div>
    </div>
</div>
