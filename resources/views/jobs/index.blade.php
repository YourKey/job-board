<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Jobs') }}
        </h1>
    </x-slot>

    @forelse($jobs as $job)
        <div class="container mx-auto max-w-4xl sm:px-6 lg:px-8 mb-5">
            <div class="card bg-base-100">
                <div class="card-body">
                    <div class="card-title">
                        <a class="link link-primary" href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info my-4">{{ __('No published vacancies found') }}</div>
    @endforelse
    <div class="container mx-auto max-w-4xl sm:px-6 lg:px-8 mb-5">{{ $jobs->links() }}</div>

</x-app-layout>
