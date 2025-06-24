<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{

    public $title;
    public $options = [];

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'options' => 'required|array|min:1|max:10',
        'options.*' => 'required|min:1|max:255'
    ];

    protected $messages = [
        'options.required' => 'You must have at least one option.',
        'options.*' => 'The option can\'t be empty.'
    ];

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function createPoll()
    {
        $this->validate();
        // Here you would typically save the poll to the database
        $poll = Poll::create([
            'title' => $this->title
        ]);

        foreach ($this->options as $option) {
            $poll->options()->create(['name' => $option]);
        }

        $this->dispatch('pollCreated'); // Dispatch an event to notify the parent component
        $this->reset(['title', 'options']); // Reset the title
    }

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
