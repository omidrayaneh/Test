@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/dropzone.css')}}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header ">Edt  tag <span style="color: red">{{$tag->title}}</span></div>
                    @if(Session::has('error'))
                        <div class="text-center">
                            <span class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST"action="/tags/{{$tag->id}}">
                            @csrf
                            <input type="hidden" value="PATCH" name="_method">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Tag Tile</label>

                                <div class="col-md-6">
                                    <input id="title" value="{{$tag->title}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title"   autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Tag Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description"   autocomplete="description" >{{$tag->description}}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right">Tag Status</label>

                                <div class="col-md-6">
                                    <select name="status" type="text" class="form-control @error('status') is-invalid @enderror"  autocomplete="description" >
                                        <option @if($tag->status==0) selected @endif value="{{0}}">not active</option>
                                        <option @if($tag->status==1) selected @endif value="{{1}}">active</option>
                                    </select>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="photo" class="col-md-4 col-form-label text-md-right">Tag photos</label>
                                <div class="col-md-6">
                                    <input type="hidden" name="photo_id" id="tag-photo">
                                    <div  id="photo" class="dropzone"></div>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" onclick="photoGallery()"  class="btn btn-primary">
                                        save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/dropzone.js')}}"></script>

    <script>
        var img = @json(asset('storage/photos/'.$tag->photo->path));
        console.log(img)
        Dropzone.autoDiscover = false;
        var photosGallery = '';
        var drop = new Dropzone('#photo', {
            addRemoveLinks: true,
            acceptedFiles: ".jpg ,.png",
            maxFiles: 1,
            maxFilesize: 0.3,
            paramName: "file",
            acceptedMimeTypes: null,
            acceptParameter: null,
            enqueueForUpload: true,
            dictDefaultMessage:"add photos",
            dictFileTooBig:"photo file is big",// image size error message
            dictInvalidFileType:"file format wrong",// file type error message
            dictCancelUpload:"cancel upload",//cancel error message
            dictCancelUploadConfirmation:"are you shore cancel upload?", //cancel conform
            dictMaxFilesExceeded:"for each tag only 1 photos accepted",
            dictRemoveFile:"delete",// remove file
            url: "{{ route('photos.upload') }}",
            sending: function(file, xhr, formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success: function(file, response){
                photosGallery=response.photo_id;
            }
        });
        photoGallery = function(){
            document.getElementById('tag-photo').value = photosGallery
        }
        var mockFile = { name: "Filename", size: 12345 };

        // Call the default addedfile event handler
        drop.emit("addedfile", mockFile);

        // And optionally show the thumbnail of the file:
        drop.emit("thumbnail", mockFile, img);



    </script>
@endsection
