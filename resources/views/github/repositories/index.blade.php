@extends('layout')

@section('content')
    <flux:heading size="xl" level="1">
        Repositories
    </flux:heading>

    <flux:text class="mb-6 mt-2 text-base">This is my repositories listing</flux:text>

    <div class="flex items-center justify-end my-4">
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
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Actions</th>
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

                    <td class="px-3 py-4">
                        <flux:button.group>
                            <flux:button icon="pencil-square" variant="primary" class="cursor-pointer" size="sm">Edit</flux:button>

                            <form method="POST" action="{{ route('repositories.destroy', [$repository->owner, $repository->name]) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this repository?');">
                                @csrf
                                @method('DELETE')
                                <flux:button icon="trash" variant="danger" class="cursor-pointer" type="submit" size="sm">Delete</flux:button>
                            </form>
                        </flux:button.group>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@if (session('status'))
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div aria-live="assertive" class="pointer-events-none fixed z-20 inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
            <!--
                Notification panel, dynamically insert this into the live region when it needs to be displayed

                Entering: "transform ease-out duration-300 transition"
                From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                To: "translate-y-0 opacity-100 sm:translate-x-0"
                Leaving: "transition ease-in duration-100"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-accent shadow-lg ring-1 ring-black/5">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <svg class="size-6 text-accent-foreground" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-white-900">{{ session('status') }}</p>
                        </div>
                        <div class="ml-4 flex shrink-0">
                            <button type="button" class="inline-flex rounded-md cursor-pointer text-accent-foreground focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden">
                                <span class="sr-only">Close</span>
                                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
