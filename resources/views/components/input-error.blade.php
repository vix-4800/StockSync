@props(['for'])

<div>
    @error($for)
    <span class="text-xs font-medium text-red-500 ">
        {{ $message }}
    </span>
    @enderror
</div>
