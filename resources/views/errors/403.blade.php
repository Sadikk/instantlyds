@extends('errors::illustrated-layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('image')
    <iframe style="margin: auto" src="https://giphy.com/embed/oyFyFiXz0hrnG" width="480" height="266" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
@endsection

