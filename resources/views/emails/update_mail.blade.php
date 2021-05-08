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
                                <p>1. Sila jawab soalan kaji selidik ini supaya anda dapat perolehi maklumat terkini program:</p>
                              </td>
                            </tr>
                            <tr>
                                <td class="align-center">
                                  <a href="https://www.research.net/r/surveyarbmei2021"> Soalan kaji selidik</a>
                                </td>
                            </tr>
                            <p style="font-size: 10px; color:red">*Selepas menjawab soalan kaji selidik, anda akan dibawa ke saluran Telegram khas. Segala maklumat berkaitan program akan dihebahkan di saluran tersebut.</p>
                            <hr>
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