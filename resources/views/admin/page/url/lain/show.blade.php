@extends('layouts.main')

@section('title')
    <title>Peserta Didik | Admin Panel</title>
    <link rel="stylesheet" href="{{asset('css/pdfviewer.jquery.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <script src="{{asset('js/pdfviewer.jquery.js')}}"></script>
@endsection

@section('container')
    <d1v class="col-md-8 offset-md-2 pt-4">
        <a href="{{ route('lainnya.index', ['token' => $token]) }}" class="btn btn-light border-warning px-4 mb-4"><i
                class="fas fa-arrow-left"></i> Kembali</a>
        @if($data->type == 'text')
            <div class="bg-white shadow-sm p-2">
                {{--            i want this page only render html from string without from other afffec5tion using $data->description but the text is html format--}}
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        {!! $data->description !!}
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div id="PDFView"></div>
                </div>
            </div>
        @endif
    </d1v>
@endsection

@section('script')
    <script type="text/javascript">
        const options = {
            width: 300,
            height: 500,
        };
        $(document).ready(function () {
            $('#PDFView').pdfViewer('{{$data->url}}', options);
        });
    </script><script>
@endsection
