@extends('layouts.user')

@section('content')
<h1 class="text-xl font-semibold text-[#292727] mb-6">Notas del instalador</h1>

<div class="space-y-4">
    @foreach ($notas as $nota)
        <div class="bg-[#DCE1DE] p-4 rounded-md shadow-sm">
            {{ $nota->contenido }}
        </div>
    @endforeach
</div>
@endsection
