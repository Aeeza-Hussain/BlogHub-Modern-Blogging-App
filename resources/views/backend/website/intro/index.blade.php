@extends('backend.layouts.app')
@section('title')
Portal - Bootstrap 5 Admin Dashboard Template For Developer
@endsection
@section('sidebar')
@include('backend.components.sidebar');
@endsection

@section('content')
    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <h1 class="app-page-title">Intro Section</h1>

                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>Button1</th>
                                    <th>Button2</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             @forelse ($intros as $intro)
                                <tr>
                                <td>{{$loop->iteration}}</td>  
                                <td>{{$intro->heading}}</td>  
                                <td>{{$intro->description}}</td>  
                                <td>{{$intro->btn1_url}}</td>  
                                <td>{{$intro->btn2_url}}</td>  
                                <td>{{$intro->status}}</td>  
                                <td>
                                    
                                <a href="">Edit</a>
                                <a href="">Delete</a>

                                
                                </td>  


                                
                                
                                
                                </tr> 
                             @empty
                                 
                             @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <footer class="app-footer">
            <div class="container text-center py-3">
                <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart"
                        style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com"
                        target="_blank">SoMa BaQri</a> for developers</small>

            </div>
        </footer><!--//app-footer-->

    </div><!--//app-wrapper-->


   @endsection
   @section('scripts')
		
   @endsection