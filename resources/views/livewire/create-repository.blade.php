<div>
    <form wire:submit="save">
        <flux:fieldset>
            <flux:field>
                <flux:label>Name</flux:label>

                <flux:description>The repository name</flux:description>

                <flux:input wire:model="name" />

                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>

                <flux:textarea rows="auto" wire:model="description" />

                <flux:error name="description" />
            </flux:field>

            <flux:field>
                <flux:label>Visibility</flux:label>

                <flux:switch label="Whether the repository is public or not" align="left" wire:model="is_public" />

                <flux:error name="is_public" />
            </flux:field>

            <flux:button class="mt-4 cursor-pointer" type="submit" variant="primary">Create repository</flux:button>
        </flux:fieldset>
    </form>
</div>
