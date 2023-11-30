@extends('layouts.master')

@section('title', 'Create Group')

@section('contents')

<div class="mt-12 mx-4 px-4 rounded-md bg-blue-50 md:max-w-2xl md:mx-auto md:px-8">
    <div class="flex justify-between py-3">
        <div class="flex">

            <div class="self-center ml-3">
                <span class="text-blue-500 font-semibold">
                <p style="font-size: 30px;text-align: center;">Assignment 1 Home</p>
                </span>

                <div class="text-blue-500" style="text-align: center;">
                    <div class="mt-1">
                    
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, { title: 'Shop Info' });
    </script>
@endsection
