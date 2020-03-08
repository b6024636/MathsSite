<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\School\SchoolAddressController;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $schools = \App\Models\Schools\School::all();

        return view('schools/viewschools', ['allSchools' => $schools]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('schools/createschool');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
//        echo '<pre>';
//        print_r($request->all());;
//        print_r($request->allFiles());
//        print_r(get_class_methods($request));
//        die();
//        $this->validate($request, [
//            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//        ]);

        /*if($request->hasFile('logo')){
            die('true');
            $image = $request->file('logo');
            $imageName = $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/' . $this->getImagePath($imageName));
            $image->move($destinationPath, $imageName);
           // $this->save();
        }
        die('false');*/

        /*if($request->logo){
            $image = $request->file('logo');
            $imageName = $request->logo->getClientOriginalExtension();
            $destinationPath = public_path('/images/' . $this->getImagePath($imageName));
            $image->move($destinationPath, $imageName);
            // $this->save();
        }*/

        $addressRequest = new \Illuminate\Http\Request();
        $addressRequest->replace([
            'address1' => $request->get('address1'),
            'address2' =>  $request->get('address2'),
            'postcode' =>  $request->get('postcode'),
            'county' =>  $request->get('county'),
            'country' =>  $request->get('country'),
        ]);
        $schoolAddress = new SchoolAddressController();
        $address = $schoolAddress->store($addressRequest);



        $imageName = $request->get('logo');

        \App\Models\Schools\School::create([
            'Name' => $request->get('name'),
            'Contact_Number' => $request->get('contact'),
            'Address_id' => $address,
            'Email' => $request->get('email'),
            'Logo' => isset($imageName) ? $this->getImagePath($imageName) . '/' . $imageName : 'null',
            'Pending' => true,
        ]);
        return redirect('schools/school');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $school = \App\Models\Schools\School::find($id);
        $address = \App\Models\Schools\SchoolAddress::find($school->Address_id);
        $schoolArr = [
            'Name' => $school->Name,
            'Contact Number' => $school->Contact_Number,
            'Email' => $school->Email,
            'Address Line 1' => $address->Address1,
            'Address Line 2' => $address->Address2,
            'Postcode' => $address->Postcode,
            'County' => $address->County,
            'Country' => $address->Country
        ];
        return view('schools/viewschool', ['school' => $schoolArr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getImagePath($imageName)
    {
        return $imageName[0] . '/' . $imageName[1];
    }
}
