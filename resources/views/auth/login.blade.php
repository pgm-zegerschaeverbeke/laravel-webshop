<x-layout>
    <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
        <x-flexbox direction="col" class="gap-8 max-w-md mx-auto w-full">
            <x-typography.heading as="h1" family="serif" weight="bold">Log in</x-typography.heading>
            
            @include('auth.partials.errors')

            <form action="{{ route('login') }}" method="POST" class="w-full" x-data="{ showPassword: false }">
                @csrf
                
                <x-flexbox direction="col" class="gap-6">
                    @include('auth.login.form-fields')

                    @include('auth.partials.form-actions', [
                        'submitText' => 'Log in',
                        'alternateText' => "Don't have an account?",
                        'alternateRoute' => 'register',
                        'alternateButtonText' => 'Register',
                    ])
                </x-flexbox>
            </form>
        </x-flexbox>
    </x-flexbox>
</x-layout>

