@if($event->image)
    <img src="{{ asset('storage/' . $event->image) }}" width="200" class="mb-2">
@endif
<input type="file" name="image" class="form-control">
