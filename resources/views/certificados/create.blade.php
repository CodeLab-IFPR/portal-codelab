<x-app-layout>
    <form method="POST" action="{{ route('certificados.store') }}">
        @csrf
        <div>
            <x-input-label for="membros_id" :value="__('Membro')" />
            <select id="membros_id" name="membros_id" required>
                @foreach($membros as $membro)
                    <option value="{{ $membro->id }}">{{ $membro->nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="descricao" :value="__('Descrição')" />
            <x-text-input id="descricao" name="descricao" required />
        </div>
        <div>
            <x-input-label for="horas" :value="__('Horas')" />
            <x-text-input id="horas" name="horas" type="number" required />
        </div>
        <div>
            <x-input-label for="data" :value="__('Data de Emissão')" />
            <x-text-input id="data" name="data" type="date" required />
        </div>
        <div>
            <x-primary-button>{{ __('Criar Certificado') }}</x-primary-button>
        </div>
    </form>
</x-app-layout>