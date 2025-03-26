@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-4">
      <x-chart.chainsaw-registration-chart/>
      <x-chart.chainsaw-registration-by-category/>
    </div>
@endsection