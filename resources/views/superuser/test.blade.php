@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <x-modal.file-modal />
    <script src="{{ asset('js/file-modal.js') }}"></script>
@endsection
