<table>
    <thead>
        <tr>
            <th>Series No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>FB Page</th>
            <th>IC No</th>
            <th>Phone No</th>
            <th>Email</th>
            <th>Package</th>
            <th>Status</th>
            <th>Claimed At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($claimeds as $claim)
            @foreach($voucher as $vou)
                @if($claim->voucher_id == $vou->voucher_id)
                    <tr>
                        <td>{{$claim->series_no}}</td>
                        <td>{{$claim->studClaim->first_name}}</td>
                        <td>{{$claim->studClaim->last_name}}</td>
                        <td>{{$claim->fb_page}}</td>
                        <td>{{ $claim->studClaim->ic }}</td>
                        <td>{{$claim->studClaim->phoneno}}</td>
                        <td>{{$claim->studClaim->email}}</td>
                        <td>
                            @if($claim->package_id != null)
                                {{$vou->pacVoucher->name}}
                            @endif
                        </td>
                        <td>{{$claim->status}}</td>
                        <td>{{ date('d/m/Y g:i A', strtotime($claim->created_at. '+8hours')) }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>