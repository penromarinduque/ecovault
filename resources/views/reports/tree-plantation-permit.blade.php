@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <!-- Include ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-4">
        <x-chart.tree-plantation-registrations/>
        <x-chart.tree-planted-by-species/>
    </div>
@endsection