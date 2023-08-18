@extends('layouts.app') 

@section('content')
<h1>Liste des utilisateurs</h1>

<ul>
    @foreach ($users as $user)
    <li>
        {{ $user->name }}
        <form method="POST" action="{{ route('send.message') }}">
            @csrf
            <input type="hidden" name="to_user_id" value="{{ $user->id }}">
            <input type="text" name="message" placeholder="Entrez votre message">
            <button type="submit">Envoyer</button>
        </form>
    </li>
    @endforeach
</ul>
@endsection