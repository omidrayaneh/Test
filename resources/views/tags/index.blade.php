@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span>All tags are displayed here</span>
                        <a class="ml-5" href="{{route('tags.create')}}">
                             new tags
                            <i class="fa fa-plus" style="color: #00ff6f"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        @if(Session::has('error'))
                            <div class="text-center">
                                <span class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</span>
                            </div>
                        @endif
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">title</th>
                                <th scope="col">slug</th>
                                <th scope="col">photo</th>
                                <th scope="col">description</th>
                                <th scope="col">status</th>
                                <th scope="col">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr>

                                    <th scope="row">{{$tag->id}}</th>
                                    <td>{{$tag->title}}</td>
                                    <td>{{$tag->slug}}</td>
                                    <td>
                                        <img width="50" height="50" src="{{'storage/photos/'.$tag->photo->path }}" class="img-fluid rounded">
                                    </td>
                                    <td>{{Str::limit($tag->description, 5, ' (...)') }}</td>
                                    <td>{{$tag->status}}</td>
                                    <td>
                                        <div>
                                            <a class="btn-delete blue mt-auto ml-1 mr-1"
                                               href="{{route('tags.edit', $tag->id)}}">
                                                <i class="fa fa-edit" data-toggle="tooltip" title="edit"></i>
                                            </a>
                                            |
                                            <button data-id="{{ $tag->id }}" style="border: none; background: none;" class="btn-delete deleteRecord">
                                                <i class="fa fa-trash-o " style="color: red" data-toggle="tooltip"
                                                   title="delete"></i>
                                            </button>
                                        </div>
                                    </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(".deleteRecord").click(function () {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
                {
                    url: "/tags/" + $(this).data("id"),
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (result) {
                        window.location.replace('/tags/');
                    }
                });

        });
    </script>
@endsection
