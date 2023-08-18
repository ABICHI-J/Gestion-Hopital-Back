@extends('layouts.app')

@section('content')
<div class="container">

    @if(Auth::user()->photo)
    <p>Ceci est ta photo actuel, tu est sûr de vouloir la supprimer ?</p>

    <img src="{{ asset(Auth::user()->photo) }}" alt="Photo de profil">

    <form method="post" action="{{ route('user.destroy.photo') }}" enctype="multipart/form-data">
        @csrf
        <button type="submit">Supprimer ma photo</button>
    </form>
    @else
    <p>Tu n'as pas de photo.</p>
    @endif


</div>
@endsection