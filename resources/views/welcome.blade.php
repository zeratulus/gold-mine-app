<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Gold Mine App - Just Another Test =]</title>
        @vite(['resources/js/app.js'])
        @vite(['resources/sass/app.scss'])
    </head>
    <body id="app">
        <app></app>
    </body>
</html>
