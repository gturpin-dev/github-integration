@extends('layout')

@section('content')
    <flux:heading size="xl" level="1">
        Hello There !
    </flux:heading>

    <flux:text class="mb-6 mt-2 text-base">This is my repositories listing</flux:text>

    <div class="flex items-center justify-end mb-4">
        <flux:button href="{{ route('repositories.create') }}" class="cursor-pointer" variant="primary" icon="plus-circle">Create a new Repository</flux:button>
    </div>

    <flux:separator variant="subtle" />

    <table class="table-auto min-w-full divide-y divide-gray-700">
        <thead>
            <tr>
                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-white sm:pl-0">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Owner</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Created at</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @foreach ($repositories as $repository)
                <tr>
                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-white sm:pl-0">{{ $repository->name }}</td>
                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-300 bold">{{ $repository->owner }}</td>
                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-300">
                        @if ($repository->isPrivate)
                            <flux:badge color="red" size="sm" inset="top bottom">Private</flux:badge>
                        @else
                            <flux:badge color="green" size="sm" inset="top bottom">Public</flux:badge>
                        @endif
                    </td>
                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-300">{{ $repository->createdAt->format('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
