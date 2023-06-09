<x-layout>
    <div class="container container--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a new Avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="mb-3">
                <input type="file" name="avatar" required >
                @error('record')
                    <p class="alert small alert-danger shadow-sm">{{$message}}</p>    
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">save</button>
        </form>
    </div>
</x-layout>