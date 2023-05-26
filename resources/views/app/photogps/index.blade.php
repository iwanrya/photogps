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
        <td>
            <iframe width="300" height="200" frameborder="1" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox={{ $post->longitude - 0.002 }},{{ $post->latitude - 0.002 }},{{ $post->longitude + 0.002 }},{{ $post->latitude + 0.002 }}&layer=mapnik&marker={{ $post->latitude }},{{ $post->longitude }}" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/?mlat=-{{ $post->latitude }}&lon={{ $post->longitude }}#map=10/{{ $post->latitude }}/{{ $post->longitude }}">View Larger Map</a></small>
        </td>
    </tr>
    @endforeach

</table>
@endsection