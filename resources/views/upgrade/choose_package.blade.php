@extends('layouts.temp')

@section('title')
Upgrade Pakej
@endsection

<style>
    /* Pricing Card */
    .pricing .cards {
      border: none;   
      color: dark; 
      background: #fda90e;
      border-radius: 1rem;
      transition: all 0.2s;
      box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.5);
    }
  
    .pricing hr {
      background-color: white;
      margin: 1.5rem 0;
    }
  
    .pricing .cards-title {
      color: dark;
      margin: 0.5rem 0;
      letter-spacing: .1rem;
      font-weight: bold;
    }
  
    .pricing .cards-price {
      color: rgb(255, 0, 13);
      font-size: 3rem;
      margin: 0;
    }
  
    .pricing .cards-price .period {
      font-size: 0.8rem;
    }
  
    .pricing ul li {
      margin-bottom: 1rem;
    }
  
    .pricing .text-muted {
      opacity: 0.7;
    }
  
    .pricing .btn {
      border-radius: 5rem;
      letter-spacing: .1rem;
      font-weight: bold;
      padding: 1rem;
      transition: all 0.2s;
    }
  
  </style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 px-3 pt-5 pb-3 text-center">
            <img src="/assets/images/logo.png" style="max-width:200px">
            <h1 class="text-dark px-4 pt-3">{{ $product->name }}</h1>
            <h6>Hai! Sila buat pilihan di bawah untuk upgrade pakej.</h6>
        </div>

        <div class="col-md-12 pb-5">
            <form action="" method="POST">
                @csrf
  
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images')}}/{{ $current_package->package_image }}" style="width:48%">
                        <h6 class="text-center">Pakej Semasa</h6>
                    </div>

                    <div class="col-md-6">
                        @foreach($package as $packages)
                        @if($current_package->price >= $packages->price)
                        @else
                            {{-- <img src="{{ asset('assets/images')}}/{{ $packages->package_image }}" style="width:48%"> --}}
                            {{-- <button type="submit" class="btn btn-dark">Pilih</button> --}}
                            <input type="image" class="mySubmit" src="{{ asset('assets/images')}}/{{ $packages->package_image }}" name="submit" style="width:48%" alt="submit"/>
                        @endif
                        @endforeach

                        <div class="pricing px-3">
                            <div class="row">
                              @foreach ($package as $packages)
                              <div class="col-lg-4">
                                {{-- <div class="cards mb-5 mb-lg-0">
                                  <div class="cards-body py-4 px-4">
                                    <h5 class="cards-title text-uppercase text-center">{{ $packages->name  }}</h5>
                                    <h6 class="cards-price text-center">RM {{ $packages->price }}</h6>
                                    <hr>
                                    <ul class="fa-ul">
                                      @foreach ($feature as $value)
                                      @if ($packages->package_id == $value->package_id)
                                        <li style="text-align: left"><span class="fa-li"><i class="fas fa-check"></i></span>{{ $value->name }}</li>
                                      @endif
                                      @endforeach
                                    </ul> 
                                    <a href="{{ url('buypackage') }}/{{ $product->product_id }}/{{ $packages->package_id }}" class="btn btn-dark btn-block text-uppercase">Beli</a>
                                  </div>
                                </div>--}}
                                <input type="image" src="{{ asset('assets/images')}}/{{ $packages->package_image }}" name="submit" style="width:48%" alt="submit" class="btn btn-block"/>
                              </div>      
                              @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                    
            </form>
        </div>
    </div>
</div>
@endsection