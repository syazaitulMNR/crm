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
                        <h3>Pendaftaran anda telah berjaya!</h3>
                        <table style="border: none; cellpadding: 0; cellspacing: 0;" class="btn btn-primary">
                          <tbody>
                            <tr>
                                <td>Assalamualaikum & Salam Sejahtera Tuan/Puan,<br><br>
                                Tahniah kerana sudah mendaftar ke Program {{ $product_name }}.
                                Program ini akan berlangsung pada:</td>
                            </tr>
                            <tr>
                                <td>
                                  <b>Tarikh</b> : {{  date('d/m/Y', strtotime($date_from))  }} - {{  date('d/m/Y', strtotime($date_to))  }}<br>
                                  <b>Masa</b> : {{  date('h:i a', strtotime($time_from))  }} - {{  date('h:i a', strtotime($time_to))  }}<br>
                                  <b>Order ID</b> : {{ $payment_id }}
                                </td>
                            </tr>
                            <hr>
                            <tr>
                              <td>                                
                                <p class="align-center">PENTING!</p>
                                <br>
                                <p>1. Sila klik pada butang di bawah untuk kemaskini maklumat peserta dan mendapatkan resit/invois:</p>
                              </td>
                            </tr>
                            <tr>
                              <td class="align-center">
                                <a href="{{ url('updateform') }}/{{ $productId }}/{{ $packageId }}/{{ $student_id }}/{{ $payment_id }}">Kemaskini</a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <p>2. Jika anda hendak menaik taraf pakej, sila klik pada butang di bawah:</p>
                              </td>
                            </tr>
                            <tr>
                              <td class="align-center">
                                
                                <a href="{{ url('upgrade-package') }}/{{ $productId }}/{{ $packageId }}/{{ $student_id }}/{{ $payment_id }}">Naik Taraf</a>
                              </td>
                            </tr>
                            <p style="font-size: 10px; color:red">*Naik taraf pakej hanya dibenarkan sebelum melakukan pengemaskinian maklumat peserta.</p>
                            <hr>
                            {{-- <tr>
                              <td class="align-center">
                                <p>Jika anda berminat untuk naik taraf pakej, sila klik butang di bawah.</p>
                              </td>
                            </tr>
                            <tr>
                              <td class="align-center">
                                <table style="width: 100%; border: none; cellpadding: 0; cellspacing: 0;" >
                                  <tbody>
                                    <tr>
                                    <td> 
                                      <a class="btn btn-primary py-3 px-4" href="{{ url('upgrade-package') }}/{{ $productId }}/{{ $packageId }}/{{ $student_id }}/{{ $payment_id }}">Naik Taraf Pakej</a>
                                      {{-- <a href="https://order.momentuminternet.com/product/up-gen-storm-2021-24-25-apr-2021-online-flex/" class="btn btn-primary py-3 px-4">Flex</a>
                                      <a href="https://order.momentuminternet.com/product/up-gen-storm-2021-24-25-apr-2021-online-vip/" class="btn btn-primary py-3 px-4">VIP</a> --}}
                                    {{-- </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr> --}}
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Sekiranya terdapat sebarang pertanyaan atau perlukan bantuan, anda boleh hubungi di talian - 0108048800</p>
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