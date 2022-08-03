<table>
    <thead>
        <tr>
            <th>first_name</th>
            <th>last_name</th>
            <th>ic</th>
            <th>email</th>
            <th>phoneno</th>
            {{-- <th>name</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($payment as $pay) 
            @foreach ($student as $stud) 
                @if ($pay->stud_id == $stud->stud_id)
                    <tr>
                        <td>{{ $stud->first_name }}</td>
                        <td>{{ $stud->last_name }}</td>
                        <td>{{ $stud->ic }}</td>
                        <td>{{ $stud->email }}</td>
                        <td>{{ $stud->phoneno }}</td>
                        {{-- <td>{{ $product->name }}</td> --}}
                    </tr>   
                @endif 
            @endforeach
        @endforeach
    </tbody>
</table>