@extends('layouts.email')

@section('content')
    <table style="border: none; cellpadding: 0; cellspacing: 0;" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            {{-- <span class="preheader">Subscribe to Coloured.com.ng mailing list</span> --}}
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table style="border: none; cellpadding: 0; cellspacing: 0;" >
                    <tr>
                      <td>
                        <h3>Pendaftaran {{ $product_name }} anda telah berjaya</h3>
                        <table style="border: none; cellpadding: 0; cellspacing: 0;" class="btn btn-primary">
                          <tbody>
                            <tr>
                                <td>Assalamualaikum & Salam Sejahtera Tuan/Cik/Puan,<br><br>
                                Terima Kasih kerana berminat untuk menyertai:</td>
                            </tr>
                            <tr>
                                <td>
                                  <b>Program</b> : {{ $product_name }}<br>
                                  <b>Tarikh</b> : {{ $date_from }} - {{ $date_to }}<br>
                                  <b>Waktu</b> : {{ $time_from }} - {{ $time_to}}<br>
                                  <b>Order ID</b> : {{ $payment_id }}
                                </td>
                                {{-- <td class="align-center">
                                    <table style="padding-left:35%; padding-right:30%">
                                      <tbody>
                                        <tr>
                                          <td style="width: 24%;"><p class="align-left"><b>Pakej</b></p></td>
                                          <td style="width: 1%;"><p class="align-left"><b>:</b></p></td>
                                          <td style="width: 25%;"><p class="align-left">{{ $package }}</p></td>
                                        </tr>
                                        <tr>
                                          <td style="width: 24%;"><p class="align-left"><b>Kuantiti</b></p></td>
                                          <td style="width: 1%;"><p class="align-left"><b>:</b></p></td>
                                          <td style="width: 25%;"><p class="align-left">{{ $quantity }}</p></td>
                                        </tr>
                                        <tr>
                                          <td style="width: 24%;"><p class="align-left"><b>Jumlah</b></p></td>
                                          <td style="width: 1%;"><p class="align-left"><b>:</b></p></td>
                                          <td style="width: 25%;"><p class="align-left">RM {{ $total }}</p></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td> --}}
                            </tr>
                            <hr>
                            <tr>
                              <td class="align-center">
                                <table style="border: none; cellpadding: 0; cellspacing: 0;" >
                                  <tbody>
                                  <tr>
                                      <td>Sila klik pada butang di bawah untuk kemaskini maklumat peserta dan mendapatkan resit pembayaran</td>
                                  </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                            <tr>
                                <td class="align-center">
                                  <table style="width: 100%; border: none; cellpadding: 0; cellspacing: 0;" >
                                    <tbody>
                                      <tr>
                                      <td> <a href="{{ url('updateform') }}/{{ $productId }}/{{ $packageId }}/{{ $student_id }}/{{ $payment_id }}" class="btn btn-primary py-3 px-4">Kemaskini</a> </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                            </tr>
                            <hr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table style="border: none; cellpadding: 0; cellspacing: 0;" class="btn btn-primary">
                          <tr>
                            <td>
                              <p>Jika anda berminat untuk upgrade pakej, sila klik butang di bawah.</p>
                              {{-- <p>Sekiranya ada sebarang pertanyaan atau perlukan bantuan, anda boleh hubungi di talian - 0108048800</p> --}}
                            </td>
                          </tr>
                          <tr>
                            <td class="align-center">
                              <table style="width: 100%; border: none; cellpadding: 0; cellspacing: 0;" >
                                <tbody>
                                  <tr>
                                  <td> 
                                    <a class="btn btn-primary py-3 px-4" href="{{ url('upgrade') }}/{{ $productId }}/{{ $packageId }}/{{ $student_id }}/{{ $payment_id }}">Upgrade Package</a>
                                    {{-- <a href="https://order.momentuminternet.com/product/up-gen-storm-2021-24-25-apr-2021-online-flex/" class="btn btn-primary py-3 px-4">Flex</a>
                                    <a href="https://order.momentuminternet.com/product/up-gen-storm-2021-24-25-apr-2021-online-vip/" class="btn btn-primary py-3 px-4">VIP</a> --}}
                                  </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Sekiranya ada sebarang pertanyaan atau perlukan bantuan, anda boleh hubungi di talian - 0108048800</p>
                        </td>
                    </tr>
                    <tr>
                      <td>Terima Kasih
                        <br><br><br>
                          Salam Kejayaan<br>
                          <b>Team Momentum</b>
                      </td>
                    </tr>
                    
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <br>     
            <p>If you received this email by mistake, simply delete it. You won't be subscribed if you don't click the confirmation link above.</p>


            <!-- START FOOTER -->
            <div class="footer">
              <table style="border: none; cellpadding: 0; cellspacing: 0;" >
                {{-- <tr>
                  <td class="content-block">
                    <span class="apple-link">Coloured.com.ng | Feminism | Culture | Law | Feminists Rising</span>
                    <br> Don't like these emails? <a href="#">Unsubscribe</a>.
                  </td>
                </tr> --}}
                <tr>
                  <td class="content-block powered-by">
                    MOMENTUM INTERNET (1079998-A) © 2020 ALL RIGHTS RESERVED​
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->
            
          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
@endsection





{{-- 



@extends('layouts.temp')

@section('content')
<div class="container text-center">

    <p class="pb-2">Hai {{ $name }},</p>

    <h2 class="fs-title pb-3">Kami telah menerima pembayaran anda!</h2>
        
    <h3>Pesanan Tiket</h3>
    {{ $date_joined }}<br>
    Order ID: {{ $payment_id }}<br>

    <hr class="my-4">

    <p> IC Number : {{ $ic }} </p>
    <p> Nama : {{ $name }} </p> 
    <p> Phone Number : {{ $phoneno }} </p> 
    <p> Package : {{ $package }} </p>
    <p> Quantity : {{ $quantity }} </p> 
    <p> Total : {{ $total }} </p> 

    <hr class="my-4">
        
    <p class="pb-2">Sila klik pada butang di bawah untuk kemaskini maklumat peserta</p>   
    <a href="#" class="btn btn-warning py-3 px-4">Kemaskini</a>

    <hr class="my-4">

    <h3>Jika terdapat sebarang pertanyaan, sila hubungi kami di talian: </h3>
        
    <p>Whatsapp   : 012-7851281</p>
        
    <p>Sekian,</p>
        
    <p>Terima kasih.</p>
        
    <p>Yang benar,</p>
        
    <p><b>MOMENTUM INTERNET</b></p>


</div>
@endsection --}}