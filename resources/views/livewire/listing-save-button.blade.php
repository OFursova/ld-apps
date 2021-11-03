<div>
    @if($savedListing)
        <x-jet-button><a href="#" wire:click.prevent="unsaveListing">Unsave</a></x-jet-button>
    @else
        <x-jet-button><a href="#" wire:click.prevent="saveListing">Save</a></x-jet-button>
    @endif
</div>
