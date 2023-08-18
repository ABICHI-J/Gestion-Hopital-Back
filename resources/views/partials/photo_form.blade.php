<form method="post" action="{{ route('user.update.photo') }}" enctype="multipart/form-data">

    @csrf

    <label for="photo">Photo :</label>
    <input type="file" name="photo" accept="image/*" required>
    @error('photo')
    <div class="error">{{ $message }}</div>
    @enderror

    <br>

    <button type="submit">Mettre à jour</button>

</form>