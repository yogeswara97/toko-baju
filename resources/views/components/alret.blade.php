@if (session('error'))
    <div class="flex items-center gap-2 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 " role="alert">
        <div class="">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div>
            <span class="font-medium">Danger alert!</span> {{ session('error') }}
        </div>
    </div>
@endif
@if (session('success'))
    <div class="flex items-center gap-2 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 " role="alert">
        <div class="">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div>
            <span class="font-medium">Success alert!</span> {{ session('success') }}
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 " role="alert">
        <i class="fa-solid fa-circle-info mt-1 mr-2"></i>
        <span class="sr-only">Danger</span>
        <div>
            <span class="font-medium">Ensure that these requirements are met:</span>
            <ul class="mt-1.5 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
