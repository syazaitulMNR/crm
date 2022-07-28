@extends('layouts.app')

@section('title')
    Voucher
@endsection


@section('content')

<div class="col-md-12 pt-3">     
      
  <div class="card-header py-2" style="border: 1px solid rgb(233, 233, 233); border-radius: 5px;">
    <a href="/dashboard"><i class="bi bi-arrow-left"></i></a> &nbsp; <a href="dashboard">Dashboard</a> / <b>Voucher</b>
  </div>

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Voucher</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
        <a href="managevoucher/create" class="btn btn-sm btn-outline-secondary"><i class="bi bi-plus-lg pr-2"></i>New Voucher</a>
      </div>
    </div>
  </div>
  
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
      <button type="button" class="close" data-bs-dismiss="alert">×</button>	
      <strong>{{ $message }}</strong>
  </div>
  @endif
  
  @if ($message = Session::get('updatesuccess'))
  <div class="alert alert-info alert-block">
      <button type="button" class="close" data-bs-dismiss="alert">×</button>	
      <strong>{{ $message }}</strong>
  </div>
  @endif

  @if ($message = Session::get('delete'))
  <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-bs-dismiss="alert">×</button>	
      <strong>{{ $message }}</strong>
  </div>
  @endif

  @if(count($vouchers) > 0)
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Date</th>
          <th scope="col" class="col-md-4">Link</th>
          <th scope="col"><i class="fas fa-cogs"></i></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($vouchers as $key => $voucher)            
          <tr>
            <td>{{ $key+1  }}</td>
            <td>
              {{ $voucher->name  }} 
              @if ($voucher->status == 'Active')
                  <span class="badge rounded-pill bg-success"> &nbsp;On Going&nbsp; </span>
              @else
              @endif
            </td>
            <td>{{ date('d/m/Y', strtotime($voucher->start_date)) }} - {{ date('d/m/Y', strtotime($voucher->end_date)) }}</td>
            <td><input type="text" class="form-control" value="{{ $links }}{{ $voucher->voucher_id }}" id="copy_{{ $links }}{{ $voucher->voucher_id }}" readonly></td>
            <td>
              <a class="btn btn-outline-info" onclick="copyToClipboard('copy_{{ $links }}{{ $voucher->voucher_id }}')" title="Copy Link"><i class="bi bi-link-45deg"></i></a>
              <a class="btn btn-outline-warning" href="{{ url('voucher/edit') }}/{{ $voucher->voucher_id }}"><i class="bi bi-pencil-square"></i></a>
              <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $voucher->voucher_id }}"><i class="bi bi-trash"></i></button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal{{ $voucher->voucher_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this event ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <a class="btn btn-danger" href="{{ url('voucher/delete') }}/{{ $voucher->voucher_id }}">Delete</a>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>   
        @endforeach
      </tbody>
    </table>
  </div>
  @else
    <p>There are no voucher to display.</p>
  @endif
  <div class="float-left pt-3">{{$vouchers->links()}}</div>
    
</div>
@endsection

<script>
  // COPY LINK
  function copyToClipboard(page_link) {
      document.getElementById(page_link).select();
      document.execCommand('copy');
      alert("Copied text to clipboard: " + event.data["text/plain"] );
  }
</script>