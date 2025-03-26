@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

       <div class="space-y-4">
            <x-cutting-permit-chart />
            <x-chart.tree-cutting-species-chart/>
            <x-chart.tree-cutting-category-chart/>
       </div>
@endsection