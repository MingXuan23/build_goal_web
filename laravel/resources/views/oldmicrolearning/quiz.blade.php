@extends('layouts.main')

@section('title', 'Quiz')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Quiz</h1>
    <form action="#" method="POST">
        @csrf
        <div class="mb-4">
            <label for="question1" class="form-label">1. What is Laravel?</label>
            <select id="question1" name="question1" class="form-select">
                <option value="A">A) A JavaScript library</option>
                <option value="B">B) A PHP framework</option>
                <option value="C">C) A CSS preprocessor</option>
                <option value="D">D) A database system</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="question2" class="form-label">2. Which command is used to create a new Laravel project?</label>
            <select id="question2" name="question2" class="form-select">
                <option value="A">A) php artisan make:project</option>
                <option value="B">B) laravel new</option>
                <option value="C">C) composer create-project laravel/laravel</option>
                <option value="D">D) npm install laravel</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
