@props(['message', 'reverse' => false])

<div class="col-start-1 col-end-8 rounded-lg">
    <div class="flex @if($reverse) flex-row-reverse @else flex-row @endif items-center gap-2">
        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-gray-200 rounded-lg shadow dark:bg-gray-800">
            A
        </div>
        <div class="relative px-4 py-2 ml-3 text-sm bg-gray-200 rounded-lg shadow dark:bg-gray-800">
            <div>
                {{ $message }}
            </div>
        </div>
    </div>
</div>
