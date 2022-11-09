<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Create vacancy') }}
        </h1>
    </x-slot>


    <div class="container mx-auto max-w-4xl sm:px-6 lg:px-8 mb-5">
        <div class="card bg-base-100">
            <div class="card-body">
                <form action="{{ route('jobs.store') }}" method="POST">
                    @csrf
                    <div class="form-control">
                        <label for="title" class="title">Title</label>
                        <input value="{{ old('title') }}" name="title" type="text" class="input input-bordered @error('title') input-error @enderror">
                        @error('title')
                            <div class="alert alert-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label for="description" class="label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="textarea textarea-bordered @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-control mt-4">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
