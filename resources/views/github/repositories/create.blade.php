@extends('layout')

@section('content')
    <flux:heading size="xl" level="1">
        Create a new Repository
    </flux:heading>

    <div class="flex items-center justify-end mb-4">
        <flux:button href="{{ route('repositories.index', 'gturpin-dev') }}" class="cursor-pointer" variant="primary" icon="plus-circle">Back to list</flux:button>
    </div>
@endsection
