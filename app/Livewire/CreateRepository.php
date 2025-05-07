<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\DataObjects\NewRepositoryData;
use App\Actions\CreateGithubRepositoryAction;

class CreateRepository extends Component
{
    #[Validate('required|min:3')]
    public string $name = '';

    public string $description = '';

    public bool $is_public = false;

    public function save(): void
    {
        $this->validate();

        (new CreateGithubRepositoryAction(
            new NewRepositoryData(
                name       : $this->name,
                description: $this->description,
                isPrivate  : ! $this->is_public,
            )
        ))->execute();

        session()->flash('status', 'Repository created successfully !');

        $this->redirectRoute('repositories.index', 'gturpin-dev');
    }

    public function render()
    {
        return view('livewire.create-repository');
    }
}
