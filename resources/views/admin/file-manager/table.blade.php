@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4 ">        

        <nav aria-label="Breadcrumb">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <!-- Always show the type -->
                <li>
                    <a>{{ ucwords(str_replace('-', ' ', $type)) }}</a>
                </li>
        
                <!-- Show the category if it exists -->
                @if(isset($category))
                    <li>
                        <span class="text-gray-400"> &gt; </span>
                    </li>
                    <li>
                        <a>{{ ucwords(str_replace('-', ' ', $category)) }}</a>
                    </li>
                @endif
        
               
                <li>
                    <span class="text-gray-400"> &gt; </span>
                </li>
                <li>
                    <a class="">Municipality</a>
                </li>

                <li>
                    <span class="text-gray-400"> &gt; </span>
                </li>
                <li>
                    <a class="font-bold">{{$municipality}}</a>
                </li>
            </ol>
        </nav>
        


       
    </div>
   
   
    

@endsection




        
       