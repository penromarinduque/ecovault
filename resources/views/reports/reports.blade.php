@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('report-tcp.show') }}"
            class="flex items-center justify-between space-x-4 p-4 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">
            <span>Tree Cutting Permit</span>
            <img src="{{ asset('images/reports/tree cutting.png') }}" alt="Tree Cutting Permits" class="w-10">
        </a>

        <a href="{{ route('report-tpp.show') }}"
            class="flex items-center justify-between space-x-4 p-4 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
            <span>Tree Plantation Permit</span>
            <img src="{{ asset('images/reports/tree plantation.png') }}" alt="Tree Plantation Permits" class="w-10">
        </a>

        <a href="{{ route('report-tp.show') }}"
            class="flex items-center justify-between space-x-4 p-4 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
            <span>Transport Permit</span>
            <img src="{{ asset('images/reports/tree transport.png') }}" alt="Transport Permits" class="w-10">
        </a>

        <a href="{{ route('report-cr.show') }}"
            class="flex items-center justify-between space-x-4 p-4 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">
            <span>Chainsaw Registration</span>
            <img src="{{ asset('images/reports/chainsaw registration.png') }}" alt="Chainsaw Registration" class="w-10">
        </a>

        <a href="{{ route('report-tcp.lt') }}"
            class="flex items-center justify-between space-x-4 p-4 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600">
            <span>Land Titles</span>
            <img src="{{ asset('images/reports/lands.png') }}" alt="Land Titles" class="w-10">
        </a>

        <a href="{{ route('report-ltp.show') }}"
            class="flex items-center justify-between space-x-4 p-4 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">
            <span>Local Transport Permit</span>
            <img src="{{ asset('images/reports/ltp.png') }}" alt="Local Transport Permit" class="w-10">
        </a>

    </div>


@endsection
