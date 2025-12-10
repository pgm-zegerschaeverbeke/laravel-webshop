<div class="js-cookie-consent cookie-consent fixed bottom-4 inset-x-4 z-100">
    <div class="max-w-6xl mx-auto">
        <div class="p-4 text-center md:text-left md:px-6 md:py-4 rounded-lg md:rounded-full bg-card border border-subtle shadow-lg bg-background">
            <x-flexbox direction="col" class="gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <x-typography.paragraph class="cookie-consent__message text-primary">
                        {!! trans('cookie-consent::texts.message') !!}
                    </x-typography.paragraph>
                </div>
                <div class="flex-shrink-0">
                    <x-flexbox class="gap-2 w-full md:w-auto">
                        <x-button 
                            type="button"
                            class="js-cookie-consent-decline cookie-consent__decline w-full md:w-auto"
                            variant="outline"
                        >
                            Decline
                        </x-button>
                        <x-button 
                            type="button"
                            class="js-cookie-consent-agree cookie-consent__agree w-full md:w-auto"
                            variant="accent"
                        >
                            {{ trans('cookie-consent::texts.agree') }}
                        </x-button>
                    </x-flexbox>
                </div>
            </x-flexbox>
        </div>
    </div>
</div>
