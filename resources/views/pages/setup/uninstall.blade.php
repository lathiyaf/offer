@extends('layouts.app')
@section("content")
    <uninstall-component
        props-url = "{{
                            json_encode([
                                    "index" => route("setup.index"),
                                    "uninstall" => route("setup.uninstall"),
                            ],JSON_HEX_APOS)
                            }}"
        props-trans = "{{ json_encode([],JSON_HEX_APOS)}}"
        props-data = "{{ json_encode(['theme'=> $data],JSON_HEX_APOS)}}"
    ></uninstall-component>
@endsection
