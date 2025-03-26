@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
      

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('report-tcp.show') }}"
                  class="p-4 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600">Tree Cutting Permit</a>
            <a href="{{ route('report-tpp.show') }}"
                  class="p-4 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">Tree Plantation Permit</a>
            <a href="{{ route('report-tp.show') }}"
                  class="p-4 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">Transport Permit</a>
            <a href="{{ route('report-cr.show') }}"
                  class="p-4 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">Chainsaw Registration</a>
            <a href="{{ route('report-tcp.lt') }}"
                  class="p-4 bg-purple-500 text-white rounded-lg shadow hover:bg-purple-600">Land Titles</a>
            <a href="{{ route('report-ltp.show') }}"
                  class="p-4 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600">Local Transport Permit</a>
      </div>
@endsection