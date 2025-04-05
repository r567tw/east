<div>
    <h1>Create Poll</h1>
    <form wire:submit.prevent="createPoll">
        <label for="">Poll Title</label>
        <input type="text" wire:model.live="title">
        @error('title')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        @error('options')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
        <button wire:click.prevent="addOption">Add Option</button>
        <ul class="list-group">
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    <label>Option {{ $index + 1 }}</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="options.{{ $index }}" />
                        <button class="btn" wire:click.prevent="removeOption({{ $index }})">Remove</button>
                    </div>
                    @error("options.{$index}")
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        </ul>
        <button class="btn btn-primary">Create Poll</button>
    </form>

</div>
