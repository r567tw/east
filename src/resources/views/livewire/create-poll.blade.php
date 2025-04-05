<div>
    <h1>Create Poll</h1>
    <form action="">
        <label for="">Poll Title</label>
        <input type="text" wire:model.live="title">
        <button wire:click.prevent="addOption">Add Option</button>
        <ul class="list-group">
            @foreach ($options as $index => $option)
                <div class="mb-4">
                    <label>Option {{ $index + 1 }}</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="options.{{ $index }}" />
                        <button class="btn" wire:click.prevent="removeOption({{ $index }})">Remove</button>
                    </div>
                </div>
            @endforeach
        </ul>
    </form>

</div>
