@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

            {{-- usage overview container --}}
            <div class="container" id="usage-overview">
                <usage-overview></usage-overview>
            </div>
            {{-- usage composition container --}}
            <div class="container" id="usage-compositions">
                <usage-compositions></usage-compositions>
            </div>



    </div>
</div>
@endsection
