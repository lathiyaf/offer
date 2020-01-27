@extends('layouts.app')
@section("content")
    <setup-index-component
        props-url = "{{
                json_encode([
                        "index" => route("setup.index"),
                        "store" => route("setup.store"),
                ],JSON_HEX_APOS)
                }}"
        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
        props-data = "{{ json_encode(['theme'=> $data],JSON_HEX_APOS)}}"
    ></setup-index-component>
@endsection
