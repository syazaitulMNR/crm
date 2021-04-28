<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Product;
use App\Package;
use App\Feature;
use validator;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ProductController
    |--------------------------------------------------------------------------
    |   This controller is for managing event details
    | 
    */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /*-- Product -------------------------------------------------------------*/

    public function viewproduct()
    {
        $product = Product::orderBy('id','asc')->paginate(15);
        return view('admin.viewproduct', compact('product'));
    }

    public function create(Request $request)
    {
        $product = Product::orderBy('id','desc')->first();

        $auto_inc_prd = $product->id + 1;
        $productId = 'PRD' . 0 . 0 . $auto_inc_prd;

        // if($request->hasFile('cover_image')){
        //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     $extension = $request->file('cover_image')->getClientOriginalExtension();
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //     $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        // } else {
        //     $fileNameToStore = 'noimage.jpg';
        // }

        Product::create([
            'product_id' => $productId,
            'name' => $request->prodname,
            'description' => $request->description,
            'date_from' => $request->date1,
            'date_to' => $request->date2,
            'time_from' => $request->time1,
            'time_to' => $request->time2,
            // 'cover_image' => $fileNameToStore,
        ]);

        return redirect('addpackage'.'/'.$productId)->with('success', 'Event Successfully Created');
    }
    
    public function edit($id)
    {
        $product = Product::where('product_id', $id)->first();
        return view('admin/updateproduct', compact('product'));        
    }

    public function update($id, Request $request)
    {
        $product = Product::where('product_id', $id)->first();             

        // Handle Image Upload
        // if($request->hasFile('cover_image')){
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('cover_image')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore=$filename.'_'.time().'.'.$extension;
        //     // Upload Image
        //     $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        // } 

        $product->name = $request->prodname;
        $product->description = $request->description;
        $product->date_from = $request->date1;
        $product->date_to = $request->date2;
        $product->time_from = $request->time1;
        $product->time_to = $request->time2;
        // if($request->hasFile('cover_image')){
        //     $product->cover_image = $fileNameToStore;
        // }
        $product->save();

        return redirect('product')->with('updatesuccess', 'Event Successfully Updated');
    }

    public function destroy($id)
    {
        $feature = Feature::where('product_id', $id);
        $product = Product::where('product_id', $id);
        $package = Package::where('product_id', $id);

        $product->delete();
        $package->delete();
        $feature->delete();

        return back()->with('delete', 'Event Successfully Deleted');
    }

    /*-- Package -------------------------------------------------------------*/
    public function view($id)
    {
        $feature = Feature::where('product_id', $id)->get();
        $product = Product::where('product_id', $id)->first();
        $package = Package::where('product_id', $id)->paginate(15);
        
        return view('admin/viewpackage', compact('feature','product', 'package'));   
    }
    
    public function pack($id)
    {
        $product = Product::where('product_id', $id)->first();
        return view('admin.addpackage', compact('product'));
    }

    public function storepack($id, Request $request)
    {
        $package = Package::orderBy('id','desc')->first();
        $feature = Feature::orderBy('id','desc')->first();

        $auto_inc_pkd = $package->id + 1;
        $packageId = 'PKD' . 0 . 0 . $auto_inc_pkd;
              
        $imagename = 'img_' . uniqid().'.'.$request->package_image->extension();
        $request->package_image->move(public_path('assets/images'), $imagename);

        Package::create(array(

            'package_id'=> $packageId,
            'name' => $request->name,
            'price'=> $request->price,
            'package_image' => $imagename,
            'product_id'=> $id

        ));  

        foreach($request->feature as $keys => $values) {

            $auto_inc_fid = $feature->id + 1;
            $featureId = 'FID' . 0 . 0 . $auto_inc_fid;
                    
           Feature::create(array(
                'feat_id'=> $featureId,
                'name'=> $values,
                'product_id'=> $id,
                'package_id'=> $packageId
            ));
        }

       // dd($package->package_image);
        return redirect('package/'.$id)->with('success', 'Package Successfully Created'); 
    }

    public function viewpack($id)
    {
        $feature = Feature::where('package_id', $id)->get();
        $package = Package::where('package_id', $id)->get();
        
        return view('package', compact('feature', 'package'));
    }
        
    public function editpack($id, $productId)
    {
        $product = Product::where('product_id', $productId)->first();
        $package = Package::where('package_id', $id)->first();
        $feature = Feature::where('package_id', $id)->get();

        return view('admin/updatepackage', compact('product', 'package', 'feature'));        
    }

    public function updatepack($packageId, $productId, Request $request){

        $product = Product::where('product_id', $productId)->first();
        $package = Package::where('package_id', $packageId)->first();    
        
        if($request->hasFile('package_image'))
        {
            $imagename = 'img_' . uniqid().'.'.$request->package_image->extension();
            $request->package_image->move(public_path('assets/images'), $imagename);
        }

        $package->name = $request->name;
        $package->price = $request->price;

        if($request->hasFile('package_image'))
        {
            $package->package_image = $imagename;
        }

        $package->save();

        // foreach($request->feature as $key => $value)
        // {
        //     $feature = Feature::where('package_id', $packageId)->where('feat_id', $request->feat_id[$key])->first();
        //     $feature->name = $value;
        //     $feature->save();
        // }

        foreach($request->features as $keys => $values) 
        {          
            $auto_inc_fid = $feature->id + 1;
            $featureId = 'FID' . 0 . 0 . $auto_inc_fid;

            Feature::create(array(
                 'feat_id'=> $featureId,
                 'name'=> $values,
                 'product_id'=> $productId,
                 'package_id'=> $packageId
             ));
        }

        return redirect('package/'.$productId)->with('updatesuccess','Package Successfully Updated!');
    }
    
    public function destroypack($packageId)
    {
        $feature = Feature::where('package_id', $packageId);
        $package = Package::where('package_id', $packageId);

        $package->delete();
        $feature->delete();
        return back()->with('delete','Package Successfully Deleted!');
    }

}
