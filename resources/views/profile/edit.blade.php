@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <!-- Adicionar o alerta aqui -->
        @if(session('status'))
            <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-content">
                    <strong>{{ __(session('status')) }}</strong>
                </div>
                <div class="progress-bar-container">
                    <div id="progress-bar" class="progress-bar"></div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Adicionar o CSS e JavaScript para o progress bar -->
    <style>
        .progress-bar-container {
            width: 100%;
            height: 4px;
            position: relative;
            margin-top: 8px;
        }
        .progress-bar {
            height: 100%;
            background-color: rgba(0,0,0,0.2);
            width: 0;
            animation: progress 3s linear forwards;
        }
        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>

    <script>
        setTimeout(function() {
            document.getElementById('alert')?.remove();
        }, 3000);
    </script>
@endsection
