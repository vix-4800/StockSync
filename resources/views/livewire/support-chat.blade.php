<div class="flex flex-col flex-shrink-0 antialiased gap-y-4 flexflex-auto md:col-span-2">
    <div class="flex flex-col h-full p-4 overflow-auto overflow-x-auto text-gray-800 transition-all duration-500 bg-gray-100 rounded-lg shadow-sm ease h-575 dark:bg-gray-900 fi-section-content-ctn ring-1 ring-gray-950/5 dark:ring-white/10">
        <div class="grid grid-cols-12 gap-y-2">
            @foreach ($conversations as $conversation)
            @foreach ($conversation->messages as $message)
            <x-chat-bubble message="{{$message->text}}" reverse='{{$message->isSentByUser()}}' />
            @endforeach
            @endforeach
        </div>
    </div>

    <form wire:submit="send" class="flex flex-row items-center w-full p-4 text-gray-800 bg-gray-100 rounded-lg shadow-sm dark:bg-gray-900 fi-section-content-ctn ring-1 ring-gray-950/5 dark:ring-white/10">
        <div class="flex-grow ml-4">
            <div class="relative w-full">
                <input wire:model="message" min="3" placeholder="{{__('Send a message')}}" class="fi-input block w-full border-s focus:border-primary-600 border-gray-200 ps-3 dark:border-white/10 py-1.5 text-base rounded-lg text-gray-950 bg-gray-100 dark:bg-gray-800 transition duration-75 placeholder:text-gray-400 focus:ring-0 dark:text-white dark:placeholder:text-gray-500 sm:text-sm sm:leading-6 bg-white/0 pe-3" required type="text">
                <x-input-error for="message" />
            </div>
        </div>
        <div class="ml-4">
            <button type="submit" class="flex items-center justify-center flex-shrink-0 px-4 py-1 rounded-lg text-gray-950 dark:text-white">
                <span>Send</span>
                <span class="ml-2">
                    <svg class="w-4 h-4 -mt-px transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </span>
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .h-575 {
        height: 575px;
        max-height: 575px;
    }

</style>
@endpush
