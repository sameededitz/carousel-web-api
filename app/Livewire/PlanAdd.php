<?php

namespace App\Livewire;

use App\Models\Plan;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PlanAdd extends Component
{
    #[Validate]
    public $name;

    #[Validate]
    public $description;

    #[Validate]
    public $price;

    #[Validate]
    public $duration;

    #[Validate]
    public $duration_unit;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|max:50',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'duration_unit' => 'required|in:day,week,month,year',
        ];
    }

    public function submit()
    {
        $this->validate();
        Plan::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
        ]);

        return redirect()->route('all-plans')->with([
            'status' => 'success',
            'message' => 'Plan Added Successfully',
        ]);
    }
    public function render()
    {
        return view('livewire.plan-add');
    }
}
