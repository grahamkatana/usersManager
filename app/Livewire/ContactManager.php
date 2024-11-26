<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;
use Illuminate\Validation\Rule;

class ContactManager extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $isEditMode = false;
    public $recordId;
    public $name;
    public $email;
    public $phone;
    public $originalData = [];
    public $hasChanges = false;

    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                $this->isEditMode
                    ? Rule::unique('contacts', 'email')->ignore($this->recordId)
                    : 'unique:contacts,email'
            ],
            'phone' => [
                'required',
                'regex:/^07[0-9]{9}$/',
                $this->isEditMode
                    ? Rule::unique('contacts', 'phone')->ignore($this->recordId)
                    : 'unique:contacts,phone'
            ],
        ];
    }

    protected $messages = [
        'phone.regex' => 'Phone number must start with 07 and be 11 digits long.',
        'email.unique' => 'This email is already taken.',
        'phone.unique' => 'This phone number is already taken.',
    ];

    public function render()
    {
        return view('livewire.contact-manager', [
            'contacts' => Contact::paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    public function edit($id)
    {
        $data = Contact::findOrFail($id);
        $this->recordId = $id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->phone = $data->phone;
        $this->originalData = [
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
        ];
        $this->isOpen = true;
        $this->isEditMode = true;
        $this->hasChanges = false;
    }

    public function store()
    {
        $this->validate($this->rules());

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('message', 'Record created successfully.');
        $this->closeModal();
    }

    public function update()
    {
        $this->validate($this->rules());
        Contact::find($this->recordId)->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        session()->flash('message', 'Record updated successfully.');
        $this->closeModal();
    }

    public function delete()
    {
        Contact::find($this->recordId)->delete();
        session()->flash('message', 'Record deleted successfully.');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->recordId = null;
        $this->hasChanges = false;
        $this->originalData = [];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules());

        if ($this->isEditMode) {
            $this->hasChanges =
                $this->name !== $this->originalData['name'] ||
                $this->email !== $this->originalData['email'] ||
                $this->phone !== $this->originalData['phone'];
        }
    }
}
