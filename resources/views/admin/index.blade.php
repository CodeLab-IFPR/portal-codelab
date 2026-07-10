@extends('layouts.admin')

<!-- Titulo -->
@section('title')
Dashboard
@endsection
<!-- Titulo -->

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Home</h3>
            </div>
        </div>
    </div>
</div>

<div class="admin-home-launchpad">
    @can('Visualizar Lançamento')
        <a href="{{ route('lancamentos.index') }}" class="admin-home-launch-button" aria-label="Acessar lançamentos">
            <i class="bi bi-rocket-takeoff" aria-hidden="true"></i>
            <span>Lançamentos</span>
        </a>
    @endcan
</div>
@endsection
