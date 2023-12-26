<?php

namespace App\Http\Controllers;

use App\Models\Add_NewProducts;
use Illuminate\Http\Request;

class AddNewProductsController extends Controller
{
    public function ProductLayout()
    {

        $pagetitle = 'Add Product';
        return view('ProductAddedd/new_product_add', compact('pagetitle'));
    }

    public function addNewProduct(Request $request)
    {
        $getvendorId = session()->get('getsessionuserid');
        $model = new Add_NewProducts();
        $request->validate([
            'p_name' => 'required',
            'p_price' => 'required',
            'p_desc' => 'required',
            'p_image' => 'required|mimes:jpg,jpeg,png',
            'p_stock' => 'required',
        ]);

        // Get the value of the checkbox input
        $is_stocked = $request->input('out_of_stock', 0);

        // Handle file upload
        $image = $request->file('p_image');
        $ext = $image->getClientOriginalExtension();
        $file = time() . '.' . $ext;
        $image->move(public_path('/NewProductImages'), $file);

        //set values in tables
        $model->p_image = $file;
        $model->v_id = $getvendorId;
        $model->p_name = $request->p_name;
        $model->p_price = $request->p_price;
        $model->p_desc = $request->p_desc;
        $model->p_stock = $request->p_stock;
        $model->out_of_stock = $is_stocked;
        $model->save();
        return view('ProductAddedd/new_product_add');
    }

    public function ProductListing()
    {
		
		$getvendorId = session()->get('getsessionuserid');
        $pagetitle = 'Product Listing';
        $productListing['products'] = Add_NewProducts::where('v_id', $getvendorId)->get();
        return view('ProductAddedd/product_listing', $productListing, compact('pagetitle'));
    }
    public function ProductDelete($id)
    {
        $deleteProduct = Add_NewProducts::where('id', $id);
        $deleteProduct->delete();
        return redirect('/product/Listing');
    }
    public function ProductEdit(Request $request, $id)
    {
        $ProductEdit['product'] = Add_NewProducts::where('id', $id)->get();
        return view('ProductAddedd/product_edit', $ProductEdit);
    }

    public function ProductUpdate(Request $request, $id)
    {
        $model = Add_NewProducts::where('id', $id)->first();
        $getvendorId = session()->get('getsessionuserid');

        $is_stocked = $request->input('out_of_stock', 0);

        $image = $request->file('p_image');
        if ($image) {
            $ext = $image->extension();
            $file = time() . '.' . $ext;
            $image->move(public_path('/NewProductImages'), $file);
            $model->p_image = $file;
        }
        //set other values in tables
        $model->v_id = $getvendorId;
        $model->p_name = $request->p_name;
        $model->p_price = $request->p_price;
        $model->p_desc = $request->p_desc;
        $model->p_stock = $request->p_stock;
        $model->out_of_stock = $is_stocked;
        $model->update();

        return redirect('/product/Listing');
    }

}
