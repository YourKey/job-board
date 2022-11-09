<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ $job->title }}
            @can('edit-job', $job)
                <x-buttons.edit-button :href="route('jobs.edit', $job)" />
            @endcan
            @can('delete-job', $job)
                <x-buttons.delete-button :action="route('jobs.destroy', $job)" />
            @endcan
        </h1>
    </x-slot>


    <div class="container mx-auto max-w-4xl sm:px-6 lg:px-8 mb-5">
        <div class="card bg-base-100">
            <div class="card-body">
                {{ $job->description }}
            </div>
        </div>
    </div>

</x-app-layout>
