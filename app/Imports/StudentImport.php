<?php

namespace App\Imports;

use App\Student;
use App\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Illuminate\Contracts\Queue\ShouldQueue;

// class StudentImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
// class StudentImport implements ToModel, WithChunkReading, WithHeadingRow
class StudentImport implements ToCollection, WithChunkReading, WithHeadingRow
{
    // use Importable;

    public function collection(Collection $rows)
    {
        // dump($rows[2]);

        $stud_id = 'MI' . uniqid();
        $payment_id = 'OD' . uniqid();

        foreach ($rows as $row) 
        {
            $student = Student::where('ic', $row['ic'])->first();

            if(Student::where('ic', $row['ic'])->exists()){

                Payment::create([
                    'payment_id'    => $payment_id,
                    'pay_price'     => $row['price'], 
                    'quantity'      => $row['quantity'],
                    'totalprice'    => $row['payment'],
                    'status'        => $row['status'],
                    'pay_method'    => $row['pay_method'], 
                    'stud_id'       => $student->stud_id,
                    'offer_id'      => $row['offer_id'], 
                    'user_id'      => $row['user_id'],
                    'product_id'    => $row['product_id'],
                    'package_id'    => $row['package_id'],
                ]);

            }else{

                Student::create([
                    'stud_id'    => $stud_id,
                    'first_name' => $row['first_name'],
                    'last_name'  => $row['last_name'], 
                    'ic'         => $row['ic'],
                    'email'      => $row['email'],
                    'phoneno'    => '+' . $row['phoneno'],
                ]);

                Payment::create([
                    'payment_id'    => $payment_id,
                    'pay_price'     => $row['price'], 
                    'quantity'      => $row['quantity'],
                    'totalprice'    => $row['payment'],
                    'status'        => $row['status'],
                    'pay_method'    => $row['pay_method'], 
                    'stud_id'       => $stud_id,
                    'offer_id'      => $row['offer_id'], 
                    'user_id'      => $row['user_id'],
                    'product_id'    => $row['product_id'],
                    'package_id'    => $row['package_id'],
                ]);

            }
        }
        
    }

    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    // public function model(array $row)
    // {
    //     // $student = Student::orderBy('id','Desc')->first();

    //     // $auto_inc = $student->id + 1;
    //     // $stud_id = 'MI' . 0 . 0 . $auto_inc;
        
    //     if(Student::where('ic', $row['ic'])->exists()){
    //     }else{
    //         return new Student([
    //             // 'stud_id'    => $stud_id,
    //             'stud_id'    => $row['stud_id'],
    //             'first_name' => $row['first_name'],
    //             'last_name'  => $row['last_name'], 
    //             'ic'         => $row['ic'],
    //             'email'      => $row['email'],
    //             'phoneno'    => $row['phoneno'],                
    //         ]);
    //     }
        
    // }

    public function chunkSize(): int
    {
        return 1000;
    }
}
