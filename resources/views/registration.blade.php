@extends('layouts.auth')

@section('content')
    @livewire('registration', [
        'upline' => $upline,
        'team' => $team,
    ])
@endsection
