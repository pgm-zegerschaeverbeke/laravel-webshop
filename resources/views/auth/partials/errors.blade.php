@if(session('error'))
    <x-flexbox class="bg-red-50 border border-red-200 rounded-md p-4">
        <x-typography.paragraph class="text-red-600">{{ session('error') }}</x-typography.paragraph>
    </x-flexbox>
@endif

@if($errors->any())
    <x-flexbox direction="col" class="gap-2 bg-red-50 border border-red-200 rounded-md p-4">
        @foreach($errors->all() as $error)
            <x-typography.paragraph class="text-red-600">{{ $error }}</x-typography.paragraph>
        @endforeach
    </x-flexbox>
@endif

