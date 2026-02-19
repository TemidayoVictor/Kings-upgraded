<div class="mt-1">
    <form method="post" action=" {{route('logout')}} "  class="w-full">
        @csrf
        <flux:button type="submit" size="sm" variant="danger" class="w-full">Logout</flux:button>
    </form>
</div>
