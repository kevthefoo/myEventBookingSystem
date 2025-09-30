@extends('layouts.main')

@section('title')
    Test
@endsection

@section('content')
    <div class="mb-4 flex w-full justify-start">
        <form method="POST" action="/addcategory" class="flex h-[300px] w-[200px] flex-col justify-end border-2 border-white">
            @csrf
            <button type="submit" class="cursor-pointer border-2 border-white px-4 py-2">Submit</button>
        </form>
    </div>
@endsection
