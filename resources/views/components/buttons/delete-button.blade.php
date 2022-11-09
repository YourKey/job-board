<form class="inline-block" action="{{ $action }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-ghost btn-outline">❌️</button>
</form>
