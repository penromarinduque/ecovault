@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    
    <div class="space-y-4">
        <x-cutting-permit-chart />
        <x-chart.tree-cutting-species-chart />
        <x-chart.tree-cutting-category-chart />
    </div>
@endsection