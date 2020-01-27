@extends('layouts.app')
@section("content")
    <display-index-component
        props-url = "{{
                json_encode([
                        "index" => route("settings.index"),
                ],JSON_HEX_APOS)
                }}"
        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
        props-data = "{{ json_encode([],JSON_HEX_APOS)}}"
    ></display-index-component>
@endsection
