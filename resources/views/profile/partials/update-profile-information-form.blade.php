<div class="container pt-4">
    <div class="bg-white overflow-hidden shadow-sm rounded-4 card">
        <div class="card-body p-4 p-lg-5">
            <section>
                <header>
                    <h2 class="fs-4 fw-medium mb-4">{{ __('Profile Information') }}</h2>
                    <p class="text-muted mb-4">{{ __("Update your account's profile information and email address.") }}</p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="mt-6">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="name" class="form-label"><strong>{{ __('Name') }}:</strong></label>
                        <input type="text" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name"
                            value="{{ old('name', $user->name) }}" 
                            required 
                            autofocus>
                        @error('name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><strong>{{ __('Email') }}:</strong></label>
                        <input type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email"
                            value="{{ old('email', $user->email) }}" 
                            required>
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> {{ __('Save') }}
                        </button>

                        @if (session('status') === 'profile-updated')
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
