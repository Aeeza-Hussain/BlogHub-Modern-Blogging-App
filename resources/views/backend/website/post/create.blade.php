@extends('backend.layouts.app')
@section('title')
    Dashboard | Intro section
@endsection
@section('sidebar')
    @include('backend.components.sidebar')
@endsection
@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">

                        <h3 class="fw-bold mb-1">Create Your Account</h3>

                        <form action="{{route('intro.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Heading</label>
                                <input type="text" name="heading" class="form-control"
                                    placeholder="Enter your full Heading">
                                @error('heading')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input type="description" name="description" class="form-control"
                                    placeholder="Enter your description">
                                @error('description')
                                                                      <span class="text-danger">{{$message}}</span>

                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Btn1</label>
                                <input type="text" name="btn1" class="form-control">
                                @error('btn1')
                                                                        <span class="text-danger">{{$message}}</span>

                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Btn2</label>
                                <input type="text" name="btn2" class="form-control">
                                @error('btn2')
                                                                       <span class="text-danger">{{$message}}</span>

                                @enderror
                            </div>
                        <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                        <footer class="app-footer">
                            <div class="container text-center py-3">
                                <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                                <small class="copyright">Designed with <span class="sr-only">love</span><i
                                        class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link"
                                        href="http://themes.3rdwavemedia.com" target="_blank">Soma Baqri</a> for
                                    developers</small>

                            </div>

                        </footer><!--//app-footer-->

                    </div><!--//app-wrapper-->
                </div>
            </div>
    </section>
@endsection


@section('scripts')
@endsection