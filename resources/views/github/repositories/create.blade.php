@extends('layout')

@section('content')
    <flux:heading size="xl" level="1">
        Create a new Repository
    </flux:heading>

    <div class="flex items-center justify-start my-4">
        <flux:button href="{{ route('repositories.index', 'gturpin-dev') }}" class="cursor-pointer" variant="primary" icon="arrow-uturn-left">Back to list</flux:button>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-24">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-3xl">
            <livewire:create-repository />
        </div>
    </div>
@endsection
