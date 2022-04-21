<table>
    <thead>
        <tr>
            <th>first_name</th>
            <th>last_name</th>
            <th>ic</th>
            <th>email</th>
            <th>phoneno</th>
            <th>name</th>
        </tr>
    </thead>
    <tbody>
            @foreach ($studentpay as $keystud => $valpay) 
                @foreach ($valpay as $datastud) 
                <tr>
                    <td>{{ $datastud->first_name }}</td>
                    <td>{{ $datastud->last_name }}</td>
                    <td>{{ $datastud->ic }}</td>
                    <td>{{ $datastud->phoneno }}</td>
                    <td>{{ $datastud->email }}</td>
                    <td>{{ $product->name }}</td>
                </tr>    
                @endforeach
            @endforeach

            @if (count($ticket) >= 1)
                @foreach ($studenttic as $keytic => $valtic)
                    @foreach ($valtic as $datatic) 
                    <tr>
                        <td>{{ $datatic->first_name }}</td>
                        <td>{{ $datatic->last_name }}</td>
                        <td>{{ $datatic->ic }}</td>
                        <td>{{ $datatic->phoneno }}</td>
                        <td>{{ $datatic->email }}</td>
                        <td>{{ $product->name }}</td>
                    </tr>    
                    @endforeach
                @endforeach
            @endif
            {{-- <td>John</td>
            <td>Doe</td>
            <td>912345006789</td>
            <td>example@gmail.com</td>
            <td>+60123456789</td>
            <td>+60123456789</td> --}}
</tbody>