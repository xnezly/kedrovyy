@extends('theme')
@section('title', 'Номера')
@section('content')
    <h1>Номера</h1>
    <p class="sub-text">Выберите комфортный номер для вашего отдыха</p>

    <div class="card-container rooms__grid">
        @forelse($rooms as $room)
            @include('parts.room', ['room' => $room])
        @empty
            <p class="text-muted mb-0">Номера временно недоступны</p>
        @endforelse
    </div>

    {{ $rooms->links('vendor.pagination.custom') }}
@endsection
