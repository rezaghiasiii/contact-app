<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {

        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');

        $contacts = Contact::latestFirst()->paginate(5);

        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $contact = new Contact();
        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');
        return view('contacts.create', compact('companies','contact'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);


        Contact::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => $request->company_id,
        ]);

        return redirect()->route('contacts.index')->with('message', 'Contact Created Successfully');

    }

    public function show($id)
    {
        $contact = Contact::find($id);
        return view('contacts.show', compact('contact'));
    }

    public function edit($id)
    {
        $companies = Company::orderBy('name')->pluck('name', 'id')->prepend('All Companies', '');

        $contact = Contact::findOrFail($id);

        return view('contacts.edit',compact('companies','contact'));
    }

    public function update(Request $request,$id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate(
          [
              'first_name' => 'required',
              'last_name' => 'required',
              'phone' => 'required',
              'email' => 'required|email',
              'address' => 'required',
              'company_id' => 'required|exists:companies,id',
          ]
        );

        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'company_id' => $request->company_id,
        ]);

        return redirect()->route('contacts.index')->with('message','Contact Updated Successfully');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index')->with('message','Contact Deleted Successfully');
    }
}
