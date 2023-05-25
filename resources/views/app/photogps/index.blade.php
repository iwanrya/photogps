@extends('app/common/layout')

@section('content')
<table class="table" style="width: 800px;">
    <tr>
        <th style="width: 40%"></th>
        <th style="width: 100px;">Latitude</th>
        <th style="width: 100px;">Longitude</th>
        <th style="width: 120px;">Created On</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td><img src="{{ $post->image_thumbnail }}"></td>
        <td>{{ $post->latitude }}</td>
        <td>{{ $post->longitude }}</td>
        <td>{{ $post->created_at_formatted }}</td>
    </tr>
    @endforeach

</table>
@endsection