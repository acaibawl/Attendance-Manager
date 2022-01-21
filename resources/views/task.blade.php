@extends('layouts.default')
@section('content')
    <h1>タスク</h1>
    <div id="task"></div>
    <script src=" {{ mix('js/Task.js') }}"></script>
@endsection
