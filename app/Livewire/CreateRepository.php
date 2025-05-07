<?php

namespace App\Livewire;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateRepository extends Component
{
    #[Validate('required|min:3')]
    public string $name = '';

    public string $description = '';

    public bool $is_public = false;

    public function save(): void
    {
        $this->validate();

        Log::info([
            'name' => $this->name,
            'description' => $this->description,
            'is_private' => ! $this->is_public,
        ]);

        session()->flash('status', 'Repository created successfully !');

        $this->redirectRoute('repositories.index', 'gturpin-dev');
    }

    public function render()
    {
        return view('livewire.create-repository');
    }
}
