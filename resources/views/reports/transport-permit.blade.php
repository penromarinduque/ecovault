@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <!-- Include ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="space-y-4">
        <x-chart.tree-transport-permits/>
        <x-chart.tree-species-transported/>
    </div>
@endsection
